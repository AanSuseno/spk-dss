<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Projects extends BaseController
{
    public function index($dss)
    {
        $data_view = [
            'title' => strtoupper($dss),
            'dss' => $dss,
            'page_master' => $dss,
            'page_sub' => $dss . "-project",
            'projects' => model('Projects')->where('dss', $dss)->find()
        ];
        return view('dss/project', $data_view);
    }

    public function create($dss) {
        $data_insert = [
            'name' => $this->request->getPost('name'),
            'dss' => $dss
        ];

        model('Projects')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully created a new project.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('projects/'.$dss));
    }

    public function delete($dss, $id) {

        model('Projects')->where([
            'id' => $id,
            'dss' => $dss
        ])->delete();

        session()->setFlashdata('msg', 'Project deleted successfully.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('projects/'.$dss));
    }
}
