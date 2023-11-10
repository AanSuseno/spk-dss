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
}
