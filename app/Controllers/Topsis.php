<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Topsis extends BaseController
{
    public function index()
    {
        $data_view = [
            'title' => 'Technique for Order of Preference by Similarity to Ideal Solution',
            'page_master' => 'topsis',
            'page_sub' => 'topsis-index'
        ];
        return view('dss/topsis/index', $data_view);
    }

    function detail($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        return redirect()->to(base_url("topsis/$id_project/criteria/"));
    }

    function criteria($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('TopsisCriteria')->where(['id_projects' => $id_project])->find(); 
        $total_criteria_weight = 0;
        foreach ($criteria as $key => $c) {
            $total_criteria_weight += $c['weight'];
        }

        $data_view = [
            'title' => $project->name . " - Technique for Order of Preference by Similarity to Ideal Solution",
            'id_project' => $id_project,
            'page_master' => 'topsis',
            'page_sub' => 'topsis-project',
            'criteria' => $criteria,
            'total_criteria_weight' => $total_criteria_weight,
        ];
        return view('dss/topsis/criteria', $data_view);
    }

    function criteria_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        if(!model('UsersLimit')->canCreateNewCriteria()) {
            session()->setFlashdata('msg', "You have reached the maximum criteria limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('topsis/' . $id_project . '/criteria'));
        }

        $name = $this->request->getPost('name');
        $c_b = $this->request->getPost('cost_benefit');
        $weight = (float) $this->request->getPost('weight');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('topsis/' . $id_project . '/criteria'));
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

        model('TopsisCriteria')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully added a new criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('topsis/' . $id_project . '/criteria'));
    }

    function criteria_delete($id_project, $id_topsis_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_topsis_criteria
        ];

        model('TopsisCriteria')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('topsis/' . $id_project . '/criteria'));
    }

    function sub_criteria_create($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        if (!model('UsersLimit')->canCreateNewSubCriteria()) {
            session()->setFlashdata('msg', "You have reached the maximum sub criteria limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('topsis/' . $id_project . '/sub_criteria'));
        }

        $name = $this->request->getPost('name');
        $weight = (float) $this->request->getPost('weight');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('topsis/' . $id_project . '/criteria'));
        }

        $data_insert = [
            'id_projects' => $id_project,
            'id_topsis_criteria' => $id_criteria,
            'name' => $name,
            'weight' => $weight
        ];

        model('TopsisSubCriteria')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully added a new sub criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('topsis/' . $id_project . '/criteria'));
    }

    function sub_criteria_json($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        $sub_criteria = model('TopsisSubCriteria')
            ->select('name, id, weight')
            ->where([
                'id_projects' => $id_project,
                'id_topsis_criteria' => $id_criteria
            ])->find();

        return json_encode(['sub_criteria' => $sub_criteria]);
    }

    function sub_criteria_delete($id_project, $id_sub_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        model('TopsisSubCriteria')->where([
            'id_projects' => $id_project,
            'id' => $id_sub_criteria
        ])->delete();

        session()->setFlashdata('msg', 'Successfully deleted a sub criteria.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('topsis/' . $id_project . '/criteria'));
    }

    function alternatives($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('TopsisCriteria')->where(['id_projects' => $id_project])->find(); 
        $alternatives = model('TopsisAlternatives')->where(['id_projects' => $id_project])->find();
        $sc = [];
        $sub_criteria = [];
        $alternatives_weight = [];$total_criteria_weight = 0;
        foreach ($criteria as $key => $c) {
            $total_criteria_weight += $c['weight'];
        }

        foreach ($criteria as $key => $c) {
            $sc[$c['id']] = model('TopsisSubCriteria')->where(['id_topsis_criteria' => $c['id']])->find();
        }

        foreach ($sc as $key => $sc_c) {
            foreach ($sc_c as $keyc => $sc_sub) {
                $sub_criteria[$key][$sc_sub['id']] = $sc_sub;
            }
        }

        foreach ($alternatives as $key => $a) {
            foreach ($criteria as $keyc => $c) {
                $alternatives_weight[$a['id']][$c['id']] = model('TopsisAlternativesSubCriteria')
                ->select('sc.weight as weight, sc.name as name, sc.id as id')
                ->join('topsis_sub_criteria sc', 'sc.id = topsis_alternatives_sub_criteria.id_topsis_sub_criteria')
                ->where([
                    'topsis_alternatives_sub_criteria.id_topsis_alternatives' => $a['id'],
                    'topsis_alternatives_sub_criteria.id_topsis_criteria' => $c['id'],
                ])->first();
            }
        }

        $data_view = [
            'title' => $project->name . " - Technique for Order of Preference by Similarity to Ideal Solution",
            'id_project' => $id_project,
            'page_master' => 'topsis',
            'page_sub' => 'topsis-project',
            'criteria' => $criteria,
            'alternatives' => $alternatives,
            'alternatives_weight' => $alternatives_weight,
            'sub_criteria' => $sub_criteria,
            'total_criteria_weight' => $total_criteria_weight,
        ];
        return view('dss/topsis/alternatives', $data_view);
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
