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
            'projects' => model('Projects')
                ->where('dss', $dss)
                ->where('id_users', session()->get('id'))
                ->find()
        ];
        return view('dss/project', $data_view);
    }

    public function create($dss) {
        $name = $this->request->getPost('name');

        if (!preg_match('/^[a-zA-Z0-9\s_-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('projects/'.$dss));
        }

        $data_insert = [
            'name' => $name,
            'dss' => $dss,
            'id_users' => session()->get('id')
        ];

        model('Projects')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully created a new project.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('projects/'.$dss));
    }

    public function delete($dss, $id) {

        model('Projects')->where([
            'id' => $id,
            'dss' => $dss,
            'id_users' => session()->get('id')
        ])->delete();

        session()->setFlashdata('msg', 'Project deleted successfully.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('projects/'.$dss));
    }
}
