<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Smart extends BaseController
{
    public function index()
    {
        $data_view = [
            'title' => 'Specific, Measurable, Achievable, Relevant, dan Time-bound',
            'page_master' => 'smart',
            'page_sub' => 'smart-index'
        ];
        return view('dss/smart/index', $data_view);
    }

    function detail($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        return redirect()->to(base_url("smart/$id_project/criteria/"));
    }

    function criteria($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('SmartCriteria')->where(['id_projects' => $id_project])->find(); 
        $total_criteria_weight = 0;
        foreach ($criteria as $key => $c) {
            $total_criteria_weight += $c['weight'];
        }

        $data_view = [
            'title' => $project->name . " - Specific, Measurable, Achievable, Relevant, dan Time-bound",
            'id_project' => $id_project,
            'page_master' => 'smart',
            'page_sub' => 'smart-project',
            'criteria' => $criteria,
            'total_criteria_weight' => $total_criteria_weight,
        ];
        return view('dss/smart/criteria', $data_view);
    }

    function criteria_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }

        if(!model('UsersLimit')->canCreateNewCriteria()) {
            session()->setFlashdata('msg', "You have reached the maximum criteria limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('smart/' . $id_project . '/criteria'));
        }

        $name = $this->request->getPost('name');
        $c_b = $this->request->getPost('cost_benefit');
        $weight = (float) $this->request->getPost('weight');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('smart/' . $id_project . '/criteria'));
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

        model('SmartCriteria')->insert($data_insert);

        session()->setFlashdata('msg', 'Successfully added a new criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('smart/' . $id_project . '/criteria'));
    }

    function criteria_delete($id_project, $id_smart_criteria) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_smart_criteria
        ];

        model('SmartCriteria')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a criterion.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('smart/' . $id_project . '/criteria'));
    }

    function alternatives($id_project, $page = 'alternatives') {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();
        $criteria = model('SmartCriteria')->where(['id_projects' => $id_project])->find(); 
        $alternatives = model('SmartAlternatives')->where(['id_projects' => $id_project])->find();
        $alternativesCriteriaWeight = model('SmartAlternativesCriteria')
            ->select('smart_alternatives_criteria.id as id, smart_alternatives_criteria.weight as weight, id_smart_criteria, id_smart_alternatives')
            ->join('smart_criteria', 'smart_criteria.id = id_smart_criteria')
            ->where(['id_projects' => $id_project])->find();
        $alternatives_weight = [];
        foreach ($alternativesCriteriaWeight as $value) {
            $alternatives_weight[$value['id_smart_criteria']][$value['id_smart_alternatives']] = $value['weight'];
        }

        $data_view = [
            'title' => $project->name . " - Specific, Measurable, Achievable, Relevant, dan Time-bound",
            'id_project' => $id_project,
            'page_master' => 'smart',
            'page_sub' => 'smart-project',
            'criteria' => $criteria,
            'alternatives' => $alternatives,
            'alternatives_weight' => $alternatives_weight,
        ];

        if($page != 'alternatives') {
            return $this->utility($id_project, $page, $criteria, $alternatives, $alternatives_weight, $project);
        }
        return view('dss/smart/alternatives', $data_view);
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

    function alternatives_create($id_project) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $project = model('Projects')->where(['id' => $id_project])->get()->getRow();

        if (!model('UsersLimit')->canCreateNewAlternative()) {
            session()->setFlashdata('msg', "You have reached the maximum alternative limit.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('smart/' . $id_project . '/sub_criteria'));
        }
        
        $name = $this->request->getPost('name');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('smart/' . $id_project . '/criteria'));
        }

        // insert alternatives
        model('SmartAlternatives')->insert([
            'name' => $name,
            'id_projects' => $id_project
        ]);
        $id_alternative = model('SmartAlternatives')->insertID();

        // insert alternatives criteria weight
        foreach ($this->request->getPost('criteria') as $key => $c) {
            model('SmartAlternativesCriteria')->insert([
                'id_smart_alternatives' => $id_alternative,
                'id_smart_criteria' => $c,
                'weight' => $this->request->getPost('criteria_alternative-'.$c)
            ]);
        }

        session()->setFlashdata('msg', 'Successfully added a new alternative.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('smart/' . $id_project . '/alternatives'));
    }

    function alternatives_delete($id_project, $id_alternative) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_alternative
        ];

        model('SmartAlternativesCriteria')->where(['id_smart_alternatives' => $id_alternative])->delete();

        model('SmartAlternatives')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a alternative.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('smart/' . $id_project . '/alternatives'));
    }

    function utility($id_project, $page, $criteria, $alternatives, $alternatives_weight, $project) {
        $alternatives_min = [];
        $alternatives_max = [];
        $total_criteria_weight = 0;

        foreach ($criteria as $c) {
            $alternatives_min[$c['id']] = min($alternatives_weight[$c['id']]);
            $alternatives_max[$c['id']] = max($alternatives_weight[$c['id']]);
            $total_criteria_weight += $c['weight'];
        }

        $data_view = [
            'title' => $project->name . " - Specific, Measurable, Achievable, Relevant, dan Time-bound",
            'id_project' => $id_project,
            'page_master' => 'smart',
            'page_sub' => 'smart-project',
            'criteria' => $criteria,
            'alternatives' => $alternatives,
            'alternatives_weight' => $alternatives_weight,
            'alternatives_max' => $alternatives_max,
            'alternatives_min' => $alternatives_min,
            'total_criteria_weight' => $total_criteria_weight,
        ];
        if ($page == 'result') {
            return view('dss/smart/result', $data_view);
        }
        return view('dss/smart/utility', $data_view);
    }
}
