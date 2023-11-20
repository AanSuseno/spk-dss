<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class WeightedProduct extends BaseController
{
    public function index()
    {
        $data_view = [
            'title' => 'Weighted Product',
            'page_master' => 'wp',
            'page_sub' => 'wp-index'
        ];
        return view('dss/wp/index', $data_view);
    }

    function detail($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        return redirect()->to(base_url("wp/$id_project/criteria/"));
    }

    function criteria($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('WpCriteria')->where(['id_projects' => $id_project])->find(); 
        $total_criteria_weight = 0;
        foreach ($criteria as $key => $c) {
            $total_criteria_weight += $c['weight'];
        }

        $data_view = [
            'title' => $project->name . " - Weighted Product",
            'id_project' => $id_project,
            'page_master' => 'wp',
            'page_sub' => 'wp-project',
            'criteria' => $criteria,
            'total_criteria_weight' => $total_criteria_weight,
        ];
        return view('dss/wp/criteria', $data_view);
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

    function criteria_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        $name = $this->request->getPost('name');
        $c_b = $this->request->getPost('cost_benefit');
        $weight = (float) $this->request->getPost('weight');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
        }
        if ($c_b === 'b') {
            $c_b = 'benefit';
        } else {
            $c_b = 'cost';
        }
        if ($weight === 0) {
            session()->setFlashdata('msg', "Weight cannot zero.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
        }

        $data_insert = [
            'name' => $name,
            'cost_benefit' => $c_b,
            'id_projects' => $id_project,
            'weight' => $weight
        ];

        model('WpCriteria')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully added a new criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
    }

    function criteria_delete($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_criteria
        ];

        model('WpCriteria')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
    }
}
