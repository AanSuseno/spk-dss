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

        $total_projects = model('Projects')->where('id_users', session()->get('id'))->countAllResults();
        if ($total_projects >= 5) {
            session()->setFlashdata('msg', '"You have reached the maximum limit of projects. You can either delete older projects or create a new account to start a new project.');
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('projects/'.$dss));
        }

        $data_insert = [
            'name' => $name,
            'dss' => $dss,
            'id_users' => session()->get('id')
        ];

        model('Projects')->insert($data_insert);

        switch ($dss) {
            case 'ahp':
                $this->createAhp(model('Projects')->insertID());
                break;
            default:
                # code...
                break;
        }

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

    function createAhp($id_project) {
        model('AhpRandomIndex')->insertBatch([
            [
                'criteria_count' => 3,
                'value' => 0.58,
                'id_projects' => $id_project
            ],
            [
                'criteria_count' => 4,
                'value' => 0.9,
                'id_projects' => $id_project
            ],
            [
                'criteria_count' => 5,
                'value' => 1.12,
                'id_projects' => $id_project
            ],
            [
                'criteria_count' => 6,
                'value' => 1.24,
                'id_projects' => $id_project
            ],
            [
                'criteria_count' => 7,
                'value' => 1.32,
                'id_projects' => $id_project
            ],
            [
                'criteria_count' => 8,
                'value' => 1.41,
                'id_projects' => $id_project
            ],
            [
                'criteria_count' => 9,
                'value' => 1.45,
                'id_projects' => $id_project
            ],
            [
                'criteria_count' => 10,
                'value' => 1.49,
                'id_projects' => $id_project
            ],
        ]);
    }
}
