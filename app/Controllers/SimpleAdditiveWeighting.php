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

        $data_view = [
            'title' => $project->name . " - Simple Additive Weighting",
            'id_project' => $id_project,
            'page_master' => 'saw',
            'page_sub' => 'saw-project',
            'criteria' => model('SawCriteria')->getByProject($id_project)->find()
        ];
        return view('dss/saw/criteria', $data_view);
    }
    
    function criteria_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        $name = $this->request->getPost('name');
        $c_b = $this->request->getPost('cost_benefit');
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
            'id_projects' => $id_project
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
