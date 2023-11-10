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
        return redirect()->to(base_url("ahp/$id_project/criteria/"));
    }

    function criteria($id_project) {
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
        $data_insert = [
            'name' => $this->request->getPost('name'),
            'id_projects' => $id_project
        ];

        model('AhpCriteria')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully added a new criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('ahp/' . $id_project . '/criteria'));
    }

    function criteria_delete($id_project, $id_criteria) {
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
            'random_index' => model('AhpRandomIndex')->where(['criteria_count' => count($criteria)])->first()['value'],
        ];
        return view('dss/ahp/criteria_weight', $data_view);
    }

    function prosesCriteriaImportanceLevel($id_project) {
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

        $this->prosesCriteriaCount($id_project);
    }

    function criteria_weight_update($id_project) {
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

        $this->prosesCriteriaCount($id_project);

        // Set flashdata for success message
        session()->setFlashdata('msg', 'Successfully updated criteria level importance.');
        session()->setFlashdata('msg-type', 'success');

        // Redirect to the criteria weight page for the specified project
        return redirect()->to(base_url("ahp/$id_project/criteria_weight"));
    }

    function prosesCriteriaCount($id_project) {
        $criteria = model('AhpCriteria')->getByProject($id_project)->find();
        $modelCriteriaWeight = model('AhpCriteriaWeight');
        $modelCriteriaWeightTotal = model('ahpCriteriaWeightsTotal');
        $criteria_weight = $modelCriteriaWeight
            ->select('id_ahp_criteria_x as x, id_ahp_criteria_y as y, id, value')
            ->where(['id_projects' => $id_project])
            ->find();

        foreach ($criteria_weight as $key => $c) {
            $criteria_weight_arr[$c['x']][$c['y']] = $c['value'];
        }

        foreach ($criteria as $key => $c) {
            $criteria_weight_total[$c['id']] = 0;
        }

        foreach ($criteria as $key => $cx) :
            foreach ($criteria as $key2 => $cy) :
                $criteria_weight_total[$cy['id']] += $criteria_weight_arr[$cx['id']][$cy['id']];
            endforeach;
        endforeach;

        // set total
        foreach ($criteria_weight_total as $key => $cwt) {
            $in_db = $modelCriteriaWeightTotal->where(['id_criteria' => $key])->countAllResults();
            if ($in_db > 0) {
                $modelCriteriaWeightTotal->set([
                    'value'=> $cwt
                ])->where(['id_criteria' => $key])->update();
            } else {
                $modelCriteriaWeightTotal->insert([
                    'id_criteria' => $key,
                    'value'=> $cwt
                ]);
            }
        }
    }
}
