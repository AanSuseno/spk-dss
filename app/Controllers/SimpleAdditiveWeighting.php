<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SimpleAdditiveWeighting extends BaseController
{
    public function index()
    {
        $data_view = [
            'title' => 'Simple Additive Weighting',
            'page_master' => 'saw',
            'page_sub' => 'saw-index'
        ];
        return view('dss/saw/index', $data_view);
    }

    function detail($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        return redirect()->to(base_url("saw/$id_project/criteria/"));
    }

    function criteria($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('SawCriteria')->getByProject($id_project)->find(); 
        $total_criteria_weight = 0;
        foreach ($criteria as $key => $c) {
            $total_criteria_weight += $c['weight'];
        }

        $data_view = [
            'title' => $project->name . " - Simple Additive Weighting",
            'id_project' => $id_project,
            'page_master' => 'saw',
            'page_sub' => 'saw-project',
            'criteria' => $criteria,
            'total_criteria_weight' => $total_criteria_weight,
        ];
        return view('dss/saw/criteria', $data_view);
    }
    
    function criteria_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        $name = $this->request->getPost('name');
        $c_b = $this->request->getPost('cost_benefit');
        $weight = (float) $this->request->getPost('weight');
        if (!preg_match('/^[a-zA-Z0-9\s_-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('saw/' . $id_project . '/criteria'));
        }
        if ($c_b === 'b') {
            $c_b = 'benefit';
        } else {
            $c_b = 'cost';
        }

        $data_insert = [
            'name' => $name,
            'cost_benefit' => $c_b,
            'id_projects' => $id_project,
            'weight' => $weight
        ];

        model('SawCriteria')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully added a new criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('saw/' . $id_project . '/criteria'));
    }
    
    function criteria_delete($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_criteria
        ];

        model('SawCriteria')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('saw/' . $id_project . '/criteria'));
    }

    function alternatives($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('SawCriteria')->getByProject($id_project)->find(); 
        $alternatives = model('SawAlternatives')->where(['id_projects' => $id_project])->find();
        $alternatives_weight = [];

        foreach ($alternatives as $key => $a) {
            foreach ($criteria as $keyc => $c) {
                if (model('SawAlternativesCriteriaWeight')->where([
                    'id_alternatives' => $a['id'],
                    'id_criteria' => $c['id'],
                ])->countAllResults() === 0) {
                    model('SawAlternativesCriteriaWeight')->insert([
                        'id_alternatives' => $a['id'],
                        'id_criteria' => $c['id'],
                        'weight' => 1
                    ]);
                    $alternatives_weight[$a['id']][$c['id']] = 1;
                } else {
                    $alternatives_weight[$a['id']][$c['id']] = model('SawAlternativesCriteriaWeight')->where([
                        'id_alternatives' => $a['id'],
                        'id_criteria' => $c['id'],
                    ])->first()['weight'];
                }
            }
        }

        $data_view = [
            'title' => $project->name . " - Simple Additive Weighting",
            'id_project' => $id_project,
            'page_master' => 'saw',
            'page_sub' => 'saw-project',
            'criteria' => $criteria,
            'alternatives' => $alternatives,
            'alternatives_weight' => $alternatives_weight,
        ];
        return view('dss/saw/alternatives', $data_view);
    }

    function alternatives_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();

        d($this->request->getPost());
        
        $name = $this->request->getPost('name');
        if (!preg_match('/^[a-zA-Z0-9\s_-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('saw/' . $id_project . '/criteria'));
        }

        // insert alternatives
        model('SawAlternatives')->insert([
            'name' => $name,
            'id_projects' => $id_project
        ]);
        $id_alternative = model('SawAlternatives')->insertID();

        // insert alternatives criteria weight
        foreach ($this->request->getPost('criteria') as $key => $c) {
            model('SawAlternativesCriteriaWeight')->insert([
                'id_alternatives' => $id_alternative,
                'id_criteria' => $c,
                'weight' => $this->request->getPost('weight')[$key]
            ]);
        }

        session()->setFlashdata('msg', 'Successfully added a new alternative.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('saw/' . $id_project . '/alternatives'));
    }

    function alternatives_delete($id_project, $id_alternative) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_alternative
        ];

        model('SawAlternatives')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a alternative.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('saw/' . $id_project . '/alternatives'));
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
}
