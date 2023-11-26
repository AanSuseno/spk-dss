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

        if(!model('UsersLimit')->canCreateNewCriteria()) {
            session()->setFlashdata('msg', "You have reached the maximum criteria limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
        }

        $name = $this->request->getPost('name');
        $c_b = $this->request->getPost('cost_benefit');
        $weight = (float) $this->request->getPost('weight');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
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

    function sub_criteria_create($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        if (!model('UsersLimit')->canCreateNewSubCriteria()) {
            session()->setFlashdata('msg', "You have reached the maximum sub criteria limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('wp/' . $id_project . '/sub_criteria'));
        }

        $name = $this->request->getPost('name');
        $weight = (float) $this->request->getPost('weight');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
        }

        $data_insert = [
            'id_projects' => $id_project,
            'id_wp_criteria' => $id_criteria,
            'name' => $name,
            'weight' => $weight
        ];

        model('WpSubCriteria')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully added a new sub criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
    }

    function sub_criteria_json($id_project, $id_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        $sub_criteria = model('WpSubCriteria')
            ->select('name, id, weight')
            ->where([
                'id_projects' => $id_project,
                'id_wp_criteria' => $id_criteria
            ])->find();

        return json_encode(['sub_criteria' => $sub_criteria]);
    }

    function sub_criteria_delete($id_project, $id_sub_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        model('WpSubCriteria')->where([
            'id_projects' => $id_project,
            'id' => $id_sub_criteria
        ])->delete();

        session()->setFlashdata('msg', 'Successfully deleted a sub criteria.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
    }

    function alternatives($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('WpCriteria')->where(['id_projects' => $id_project])->find(); 
        $alternatives = model('WpAlternatives')->where(['id_projects' => $id_project])->find();
        $sc = [];
        $sub_criteria = [];
        $alternatives_weight = [];$total_criteria_weight = 0;
        foreach ($criteria as $key => $c) {
            $total_criteria_weight += $c['weight'];
        }

        foreach ($criteria as $key => $c) {
            $sc[$c['id']] = model('WpSubCriteria')->where(['id_wp_criteria' => $c['id']])->find();
        }

        foreach ($sc as $key => $sc_c) {
            foreach ($sc_c as $keyc => $sc_sub) {
                $sub_criteria[$key][$sc_sub['id']] = $sc_sub;
            }
        }

        foreach ($alternatives as $key => $a) {
            foreach ($criteria as $keyc => $c) {
                $alternatives_weight[$a['id']][$c['id']] = model('WpAlternativesSubCriteria')
                ->select('sc.weight as weight, sc.name as name, sc.id as id')
                ->join('wp_sub_criteria sc', 'sc.id = wp_alternatives_sub_criteria.id_wp_sub_criteria')
                ->where([
                    'wp_alternatives_sub_criteria.id_wp_alternatives' => $a['id'],
                    'wp_alternatives_sub_criteria.id_wp_criteria' => $c['id'],
                ])->first();
            }
        }

        $data_view = [
            'title' => $project->name . " - Simple Additive Weighting",
            'id_project' => $id_project,
            'page_master' => 'wp',
            'page_sub' => 'wp-project',
            'criteria' => $criteria,
            'alternatives' => $alternatives,
            'alternatives_weight' => $alternatives_weight,
            'sub_criteria' => $sub_criteria,
            'total_criteria_weight' => $total_criteria_weight,
        ];
        return view('dss/wp/alternatives', $data_view);
    }

    function alternatives_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();

        if (!model('UsersLimit')->canCreateNewAlternative()) {
            session()->setFlashdata('msg', "You have reached the maximum alternative limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('wp/' . $id_project . '/sub_criteria'));
        }
        
        $name = $this->request->getPost('name');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('wp/' . $id_project . '/criteria'));
        }

        // insert alternatives
        model('WpAlternatives')->insert([
            'name' => $name,
            'id_projects' => $id_project
        ]);
        $id_alternative = model('WpAlternatives')->insertID();

        // insert alternatives criteria weight
        foreach ($this->request->getPost('criteria') as $key => $c) {
            model('WpAlternativesSubCriteria')->insert([
                'id_wp_alternatives' => $id_alternative,
                'id_wp_criteria' => $c,
                'id_wp_sub_criteria' => $this->request->getPost('crit_'.$c)
            ]);
        }

        session()->setFlashdata('msg', 'Successfully added a new alternative.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('wp/' . $id_project . '/alternatives'));
    }

    function alternatives_delete($id_project, $id_alternative) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_alternative
        ];

        model('WpAlternatives')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a alternative.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('wp/' . $id_project . '/alternatives'));
    }
}
