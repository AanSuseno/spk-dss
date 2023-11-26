<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AnalyticalHierarchyProcess extends BaseController
{
    public function index()
    {
        $data_view = [
            'title' => 'Analytical Hierarchy Process',
            'page_master' => 'ahp',
            'page_sub' => 'ahp-index'
        ];
        return view('dss/ahp/index', $data_view);
    }

    function detail($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        return redirect()->to(base_url("ahp/$id_project/criteria/"));
    }

    function criteria($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();

        $data_view = [
            'title' => $project->name . " - Analytical Hierarchy Process",
            'id_project' => $id_project,
            'page_master' => 'ahp',
            'page_sub' => 'ahp-project',
            'criteria' => model('AhpCriteria')->getByProject($id_project)->find()
        ];
        return view('dss/ahp/criteria', $data_view);
    }

    function criteria_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        $total_criteria = model('AhpCriteria')->where(['id_projects' => $id_project])->countAllResults();
        $highest_random_index = model('AhpRandomIndex')
            ->where(['id_projects' => $id_project])
            ->orderBy('criteria_count', 'DESC')
            ->first()['criteria_count'];

        if(!model('UsersLimit')->canCreateNewCriteria()) {
            session()->setFlashdata('msg', "You have reached the maximum criteria limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('ahp/' . $id_project . '/criteria'));
        }

        if ($total_criteria >= $highest_random_index) {
            session()->setFlashdata('msg', "The number of criteria must not exceed the total number of random indexes ($highest_random_index).");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('ahp/' . $id_project . '/criteria'));
        }

        $name = $this->request->getPost('name');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('ahp/' . $id_project . '/criteria'));
        }

        $data_insert = [
            'name' => $name,
            'id_projects' => $id_project
        ];

        model('AhpCriteria')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully added a new criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('ahp/' . $id_project . '/criteria'));
    }

    function criteria_delete($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_criteria
        ];

        model('AhpCriteria')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('ahp/' . $id_project . '/criteria'));
    }

    function criteria_weight($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();

        if (count($criteria) === 0) {
            session()->setFlashdata('msg', 'Create criteria first.');
            session()->setFlashdata('msg-type', 'info');
            return redirect()->to(base_url('ahp/' . $id_project . '/criteria'));
        }

        $this->prosesCriteriaImportanceLevel($id_project);
        $modelCriteriaWeight = model('AhpCriteriaWeight');
        $criteria_weight = $modelCriteriaWeight
            ->select('id_ahp_criteria_x as x, id_ahp_criteria_y as y, id, value')
            ->where(['id_projects' => $id_project])
            ->find();

        foreach ($criteria_weight as $key => $c) {
            $criteria_weight_arr[$c['x']][$c['y']] = $c['value'];
        }

        $data_view = [
            'title' => $project->name . " - Analytical Hierarchy Process",
            'id_project' => $id_project,
            'page_master' => 'ahp',
            'page_sub' => 'ahp-project',
            'criteria' => $criteria,
            'criteria_weight' => $criteria_weight,
            'criteria_weight_arr' => $criteria_weight_arr,
            'random_index' => model('AhpRandomIndex')->where([
                'criteria_count' => count($criteria),
                'id_projects' => $id_project
            ])->first()['value'],
        ];
        return view('dss/ahp/criteria_weight', $data_view);
    }

    function prosesCriteriaImportanceLevel($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        // Retrieve the list of criteria for the specified project.
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();

        $modelCriteriaWeight = model('AhpCriteriaWeight');

        // Retrieve the existing criteria weights for the project.
        $criteria_weight = $modelCriteriaWeight
            ->select('id_ahp_criteria_x, id_ahp_criteria_y')
            ->where(['id_projects' => $id_project])
            ->find();

        // Iterate through each pair of criteria to ensure there is a corresponding weight entry.
        foreach ($criteria as $key => $i) {
            foreach ($criteria as $key2 => $j) {
                // Check if the criteria pair already has a weight entry, if not, insert with default value 1
                if (!in_array([
                    'id_ahp_criteria_x' => $i['id'],
                    'id_ahp_criteria_y' => $j['id'],
                ], $criteria_weight)) {
                    $data_insert = [
                        'id_ahp_criteria_x' => $i['id'],
                        'id_ahp_criteria_y' => $j['id'],
                        'value' => 1,
                        'id_projects' => (int) $id_project
                    ];
                    $modelCriteriaWeight->insert($data_insert);
                }
            }
        }

        $this->processCriteriaCount($id_project);
    }

    function criteria_weight_update($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        // Get the AhpCriteriaWeight model
        $modelCriteriaWeight = model('AhpCriteriaWeight');

        // Iterate through each criteria weight submitted in the form
        foreach ($this->request->getPost('range') as $key => $value) {
            // Extract the criteria IDs from the submitted form data
            $cx = explode('-', $this->request->getPost('criteria')[$key])[0];
            $cy = explode('-', $this->request->getPost('criteria')[$key])[1];

            // Update criteria weights based on the provided value
            if ($value >= 1) {
                // If value is greater than or equal to 1, update directly and symmetrically
                $modelCriteriaWeight->set('value', 1/$value)->where([
                    'id_ahp_criteria_x' => $cx,
                    'id_ahp_criteria_y' => $cy,
                ])->update();

                $modelCriteriaWeight->set('value', $value)->where([
                    'id_ahp_criteria_x' => $cy,
                    'id_ahp_criteria_y' => $cx,
                ])->update();
            } else {
                // If value is less than 1, perform adjustment and update symmetrically
                $value = abs($value)+2;

                $modelCriteriaWeight->set('value', $value)->where([
                    'id_ahp_criteria_x' => $cx,
                    'id_ahp_criteria_y' => $cy,
                ])->update();

                $modelCriteriaWeight->set('value', 1/$value)->where([
                    'id_ahp_criteria_x' => $cy,
                    'id_ahp_criteria_y' => $cx,
                ])->update();
            }
        }

        $this->processCriteriaCount($id_project);

        // Set flashdata for success message
        session()->setFlashdata('msg', 'Successfully updated criteria level importance.');
        session()->setFlashdata('msg-type', 'success');

        // Redirect to the criteria weight page for the specified project
        return redirect()->to(base_url("ahp/$id_project/criteria_weight"));
    }

    function processCriteriaCount($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        // Retrieve criteria data
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();
    
        // Initialize models
        $modelCriteriaWeight = model('AhpCriteriaWeight');
        $modelCriteriaPriority = model('AhpCriteriaPriority');
        $modelCriteriaWeightTotal = model('ahpCriteriaWeightsTotal');
    
        // Retrieve criteria weight data
        $criteria_weight = $modelCriteriaWeight
            ->select('id_ahp_criteria_x as x, id_ahp_criteria_y as y, id, value')
            ->where(['id_projects' => $id_project])
            ->find();
    
        // Create a criteria weight array for easier access
        foreach ($criteria_weight as $key => $c) {
            $criteria_weight_arr[$c['x']][$c['y']] = $c['value'];
        }
    
        // Initialize criteria weight total array
        foreach ($criteria as $key => $c) {
            $criteria_weight_total[$c['id']] = 0;
            $criteria_weight_nomralized_total[$c['id']] = 0;
        }
    
        // Calculate total weight for each criteria
        foreach ($criteria as $key => $cx) :
            foreach ($criteria as $key2 => $cy) :
                $criteria_weight_total[$cy['id']] += $criteria_weight_arr[$cx['id']][$cy['id']];
            endforeach;
        endforeach;
    
        // Set total criteria weights in the database
        foreach ($criteria_weight_total as $key => $cwt) {
            // Check if the criterion's total weight already exists in the database
            $in_db = $modelCriteriaWeightTotal->where(['id_criteria' => $key])->countAllResults();

            // If the criterion's total weight exists, update the value; otherwise, insert a new record
            if ($in_db > 0) {
                $modelCriteriaWeightTotal->set([
                    'value' => $cwt
                ])->where(['id_criteria' => $key])->update();
            } else {
                $modelCriteriaWeightTotal->insert([
                    'id_criteria' => $key,
                    'value' => $cwt
                ]);
            }
        }

        foreach ($criteria as $key => $cx) :
            foreach ($criteria as $key2 => $cy) :
                $temp = $criteria_weight_arr[$cx['id']][$cy['id']]/$criteria_weight_total[$cy['id']];
                $criteria_weight_nomralized_total[$cx['id']] += $temp;
            endforeach;
            $in_db = $modelCriteriaPriority->where(['id_ahp_criteria' => $cx['id']])->countAllResults();
            $priority = $criteria_weight_nomralized_total[$cx['id']]/count($criteria);

            if ($in_db > 0) {
                $modelCriteriaPriority->set([
                    'value' => $priority
                ])->where(['id_ahp_criteria' => $cx['id']])->update();
            } else {
                $modelCriteriaPriority->set([
                    'value' => $priority,
                    'id_ahp_criteria' => $cx['id']
                ])->insert();
            }
        endforeach;
    }

    function alternatives($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();
        $modelSubCriteria = model('AhpSubCriteria');
        $sub_criteria = [];
        $alternatives = model('AhpAlternatives')->getByProject($id_project)->find();

        foreach ($criteria as $key => $c) {
            $sub_criteria[$c['id']] = $modelSubCriteria->where(['id_ahp_criteria' => $c['id']])->find();
        }

        dd($alternatives);

        $data_view = [
            'title' => $project->name . " - Analytical Hierarchy Process",
            'id_project' => $id_project,
            'page_master' => 'ahp',
            'page_sub' => 'ahp-project',
            'criteria' => $criteria,
            'sub_criteria' => $sub_criteria,
            'alternatives' => $alternatives,
        ];
        return view('dss/ahp/alternatives', $data_view);
    }

    function sub_criteria($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        // Retrieve project details
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        
        // Retrieve criteria and sub-criteria for the project
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();
        $subCriteria = model('AhpSubCriteria')->getByProject($id_project)->find();
    
        // Organize sub-criteria by criteria ID
        $sub_criteria = [];
        foreach ($criteria as $key => $c) {
            $sub_criteria[$c['id']] = [];
        }
    
        // Populate sub-criteria array with relevant information
        foreach ($subCriteria as $key => $sc) {
            array_push($sub_criteria[$sc['id_ahp_criteria']], [
                'name' => $sc['name'],
                'id' => $sc['id']
            ]);
        }
    
        // Prepare data for the view
        $data_view = [
            'title' => $project->name . " - Analytical Hierarchy Process",
            'id_project' => $id_project,
            'page_master' => 'ahp',
            'page_sub' => 'ahp-project',
            'criteria' => $criteria,
            'sub_criteria' => $sub_criteria,
        ];
    
        // Load and return the view
        return view('dss/ahp/sub_criteria', $data_view);
    }
    
    function sub_criteria_create($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        if (!model('UsersLimit')->canCreateNewSubCriteria()) {
            session()->setFlashdata('msg', "You have reached the maximum sub criteria limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('ahp/' . $id_project . '/sub_criteria'));
        }

        $name = $this->request->getPost('name');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('ahp/' . $id_project . '/sub_criteria'));
        }

        // Insert a new sub-criterion
        $modelSubCriteria = model('AhpSubCriteria');
        $modelSubCriteria->insert([
            'id_ahp_criteria' => $id_criteria,
            'name' => $name
        ]);
    
        // Set flash data and redirect to the sub-criteria page
        session()->setFlashdata('msg', 'Successfully added a new sub-criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('ahp/' . $id_project . '/sub_criteria'));
    }

    function sub_criteria_delete($id_project, $id_sub_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        // Delete the specified sub-criterion
        $modelSubCriteria = model('AhpSubCriteria');
        $modelSubCriteria->where([
            'id' => $id_sub_criteria,
        ])->delete();
    
        // Set flash data and redirect to the sub-criteria page
        session()->setFlashdata('msg', 'Successfully deleted a sub-criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('ahp/' . $id_project . '/sub_criteria'));
    }

    function sub_criteria_weight($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();

        foreach ($criteria as $key => $c) {
            $this->prosesSubCriteriaImportanceLevel($id_project, $c['id']);
        }

        $this->processSubCriteriaCount($id_project);

        $data_view = [
            'title' => $project->name . " - Analytical Hierarchy Process",
            'id_project' => $id_project,
            'page_master' => 'ahp',
            'page_sub' => 'ahp-project',
            'criteria' => $criteria,
            'random_index' => model('AhpRandomIndex')
                ->where(['criteria_count' => count($criteria), 'id_projects' => $id_project])
                ->first()['value'],
        ];
        return view('dss/ahp/sub_criteria_weight', $data_view);
    }

    function prosesSubCriteriaImportanceLevel($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        // Retrieve sub-criteria for the specified criteria
        $sub_criteria = model('AhpSubCriteria')->where(['id_ahp_criteria' => $id_criteria])->find();
    
        // Initialize the model for sub-criteria weights
        $modelSubCriteriaWeight = model('AhpSubCriteriaWeights');
    
        // Retrieve existing criteria weights for the project
        $criteria_weight = $modelSubCriteriaWeight
            ->select('id_ahp_sub_criteria_x, id_ahp_sub_criteria_y')
            ->where(['id_projects' => $id_project])
            ->find();
    
        // Iterate through each pair of sub-criteria
        foreach ($sub_criteria as $key => $i) {
            foreach ($sub_criteria as $key2 => $j) {
                // Check if the pair is not already in the criteria weights
                if (!in_array([
                    'id_ahp_sub_criteria_x' => $i['id'],
                    'id_ahp_sub_criteria_y' => $j['id'],
                ], $criteria_weight)) {
                    // Insert a default weight of 1 for the new pair
                    $data_insert = [
                        'id_ahp_sub_criteria_x' => $i['id'],
                        'id_ahp_sub_criteria_y' => $j['id'],
                        'value' => 1,
                        'id_projects' => $id_project
                    ];
                    $modelSubCriteriaWeight->insert($data_insert);
                }
            }
        }
    }

    function sub_criteria_weight_json($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $sub_criteria = model('AhpSubCriteria')->select('id, name')->where(['id_ahp_criteria' => $id_criteria])->find();
        $modelSubCriteriaWeight = model('AhpSubCriteriaWeights');
        $ri = model('AhpRandomIndex')->where(['criteria_count' => count($sub_criteria), 'id_projects' => $id_project])->first()['value'];

        $criteria_weight = $modelSubCriteriaWeight
            ->select('id_ahp_sub_criteria_x as x, id_ahp_sub_criteria_y as y, id, value')
            ->where(['id_projects' => $id_project])
            ->find();

        foreach ($criteria_weight as $key => $c) {
            $criteria_weight_arr[$c['x']][$c['y']] = $c['value'];
        }

        // get only in this sub
        foreach ($sub_criteria as $key => $i) {
            foreach ($sub_criteria as $key2 => $j) {
                $criteria_weight_arr2[$i['id']][$j['id']] = $criteria_weight_arr[$i['id']][$j['id']];
            }
        }

        return json_encode(['sub_criteria' => $sub_criteria, 'weight' => $criteria_weight_arr2, 'ri' => $ri]);
    }

    function sub_criteria_weight_update($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $modelSubCriteriaWeights = model('AhpSubCriteriaWeights');

        foreach ($this->request->getPost('range') as $key => $value) {
            $cx = explode('-', $this->request->getPost('criteria')[$key])[0];
            $cy = explode('-', $this->request->getPost('criteria')[$key])[1];

            if ($value >= 1) {
                $modelSubCriteriaWeights->set('value', 1/$value)->where([
                    'id_ahp_sub_criteria_x' => $cx,
                    'id_ahp_sub_criteria_y' => $cy,
                ])->update();

                $modelSubCriteriaWeights->set('value', $value)->where([
                    'id_ahp_sub_criteria_x' => $cy,
                    'id_ahp_sub_criteria_y' => $cx,
                ])->update();
            } else {
                $value = abs($value)+2;

                $modelSubCriteriaWeights->set('value', $value)->where([
                    'id_ahp_sub_criteria_x' => $cx,
                    'id_ahp_sub_criteria_y' => $cy,
                ])->update();

                $modelSubCriteriaWeights->set('value', 1/$value)->where([
                    'id_ahp_sub_criteria_x' => $cy,
                    'id_ahp_sub_criteria_y' => $cx,
                ])->update();
            }
        }

        $this->processSubCriteriaCount($id_project);

        session()->setFlashdata('msg', 'Successfully updated criteria level importance.');
        session()->setFlashdata('msg-type', 'success');

        return redirect()->to(base_url("ahp/$id_project/sub_criteria_weight"));
    }

    function processSubCriteriaCount($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $modelSubCriteriaWeight = model('AhpSubCriteriaWeights');
        $modelSubCriteriaPriority = model('AhpSubCriteriaPriority');
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();

        foreach ($criteria as $key => $c) {
            $id_criteria = $c['id'];
            $sub_criteria = model('AhpSubCriteria')->where(['id_ahp_criteria' => $id_criteria])->find();
    
            $criteria_weight = $modelSubCriteriaWeight
                ->select('id_ahp_sub_criteria_x as x, id_ahp_sub_criteria_y as y, id, value')
                ->where(['id_projects' => $id_project])
                ->find();
        
            foreach ($criteria_weight as $key => $c) {
                $criteria_weight_arr[$c['x']][$c['y']] = $c['value'];
            }
        
            foreach ($sub_criteria as $key => $c) {
                $criteria_weight_total[$c['id']] = 0;
                $criteria_weight_nomralized_total[$c['id']] = 0;
            }
        
            foreach ($sub_criteria as $key => $cx) :
                foreach ($sub_criteria as $key2 => $cy) :
                    $criteria_weight_total[$cy['id']] += $criteria_weight_arr[$cx['id']][$cy['id']];
                endforeach;
            endforeach;

            foreach ($sub_criteria as $key => $cx) :
                foreach ($sub_criteria as $key2 => $cy) :
                    $temp = $criteria_weight_arr[$cx['id']][$cy['id']]/$criteria_weight_total[$cy['id']];
                    $criteria_weight_nomralized_total[$cx['id']] += $temp;
                endforeach;
                $in_db = $modelSubCriteriaPriority->where(['id_ahp_sub_criteria' => $cx['id']])->countAllResults();
                $priority = $criteria_weight_nomralized_total[$cx['id']]/count($sub_criteria);

                if ($in_db > 0) {
                    $modelSubCriteriaPriority->set([
                        'value' => $priority
                    ])->where(['id_ahp_sub_criteria' => $cx['id']])->update();
                } else {
                    $modelSubCriteriaPriority->set([
                        'value' => $priority,
                        'id_ahp_sub_criteria' => $cx['id']
                    ])->insert();
                }
            endforeach;
        }
    }

    function alternatives_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        if (!model('UsersLimit')->canCreateNewAlternative()) {
            session()->setFlashdata('msg', "You have reached the maximum alternative limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('ahp/' . $id_project . '/sub_criteria'));
        }

        $name = $this->request->getPost('name');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('ahp/' . $id_project . '/criteria'));
        }
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();
        $mAlternative = model('AhpAlternatives')->insert([
            'id_projects' => $id_project,
            'name' => $name
        ]);
        $id_alternative = model('AhpAlternatives')->insertID();

        foreach ($criteria as $key => $c) {
            model('AhpAlternativesSubCriteriaPriority')->insert([
                'id_ahp_alternatives' => $id_alternative,
                'id_ahp_criteria' => $c['id'],
                'id_ahp_sub_criteria' => $p["crit_".$c['id']],
            ]);
        }

        session()->setFlashdata('msg', 'Success.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('ahp/' . $id_project . '/alternatives'));
    }

    function alternatives_update($id_project, $id_alternative) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $p = $this->request->getPost();
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();

        foreach ($criteria as $key => $c) {
            model('AhpAlternativesSubCriteriaPriority')->set([
                'id_ahp_sub_criteria' => $p["crit_".$c['id']],
            ])->where([
                'id_ahp_criteria' => $c['id'],
                'id_ahp_alternatives' => $id_alternative
            ])->update();
        }

        session()->setFlashdata('msg', 'Success updated data.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('ahp/' . $id_project . '/alternatives'));
    }

    function alternatives_delete($id_project, $id_alternative) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        model('AhpAlternatives')->where([
            'id_projects' => $id_project,
            'id' => $id_alternative,
        ])->delete();

        session()->setFlashdata('msg', 'Deleted.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('ahp/' . $id_project . '/alternatives'));
    }

    function alternatives_sub_criteria($id_project, $id_alternative) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();
        $alternative_sub_c = [];

        foreach ($criteria as $key => $c) {
            $alternative_sub_c[$c['id']] = (int) model('AhpAlternativesSubCriteriaPriority')
                ->select('ahp_alternatives_sub_criteria_priority.id_ahp_sub_criteria as sub_c')
                ->join('ahp_alternatives a', 'a.id = ahp_alternatives_sub_criteria_priority.id_ahp_alternatives')
                ->join('ahp_criteria c', 'c.id = ahp_alternatives_sub_criteria_priority.id_ahp_criteria')
                ->where('a.id_projects', $id_project)
                ->where('ahp_alternatives_sub_criteria_priority.id_ahp_alternatives', $id_alternative)
                ->where('ahp_alternatives_sub_criteria_priority.id_ahp_criteria', $c['id'])
                ->first()['sub_c'];
        }
        
        return json_encode([
            'criteria' => $criteria,
            'alternative_sub_criteria' => $alternative_sub_c
        ]);
    }

    function result($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $alternatives = model('AhpAlternatives')->where(['id_projects' => $id_project])->find();
        $criteria = model('AhpCriteria')
            ->select('ahp_criteria.*, p.value as priority')
            ->join('ahp_criteria_priority p', 'p.id_ahp_criteria = ahp_criteria.id')
            ->where(['id_projects' => $id_project])->find();
        $alternative_priority = [];

        foreach ($alternatives as $key_a => $a) {
            foreach ($criteria as $key_c => $c) {
                $alternative_priority[$a['id']][$c['id']] = model('AhpAlternativesSubCriteriaPriority')
                    ->select('sc.name as name, sc_priority.value as value')
                    ->join('ahp_alternatives a', 'a.id = ahp_alternatives_sub_criteria_priority.id_ahp_alternatives')
                    ->join('ahp_criteria c', 'c.id = ahp_alternatives_sub_criteria_priority.id_ahp_criteria')
                    ->join('ahp_sub_criteria sc', 'sc.id = ahp_alternatives_sub_criteria_priority.id_ahp_sub_criteria')
                    ->join('ahp_sub_criteria_priority sc_priority', 'sc_priority.id_ahp_sub_criteria = sc.id')
                    ->where([
                        'ahp_alternatives_sub_criteria_priority.id_ahp_alternatives' => $a['id'],
                        'ahp_alternatives_sub_criteria_priority.id_ahp_criteria' => $c['id'],
                    ])->first();
            }
        }

        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();

        $data_view = [
            'title' => $project->name . " - Analytical Hierarchy Process",
            'id_project' => $id_project,
            'page_master' => 'ahp',
            'page_sub' => 'ahp-project',
            'criteria' => $criteria,
            'alternatives' => $alternatives,
            'alternative_priority' => $alternative_priority
        ];
        return view('dss/ahp/result', $data_view);
    }

    function validate_project_access($id_project) {
        $hitung = model('Projects')->where([
            'id' => $id_project,
            'id_users' => session()->get('id')
        ])->countAllResults();

        if ($hitung === 0) {
            return false;
        }

        return true;
    }

    function random_index_update($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        model('AhpRandomIndex')->set([
            'value' => $this->request->getPost('value')
        ])->where([
            'criteria_count' => $this->request->getPost('count_criteria'),
            'id_projects' => $id_project
        ])->update();

        session()->setFlashdata('msg', "Random index successfully updated.");
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url("ahp/$id_project/criteria_weight"));
    }
}
