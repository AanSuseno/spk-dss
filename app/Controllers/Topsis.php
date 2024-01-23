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

    function alternatives($id_project, $page = 'alternatives') {
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

        if ($page == 'alternatives') {
            return view('dss/topsis/alternatives', $data_view);
        } else if ($page == 'normalized') {
            return $this->normalized($data_view);
        } else if ($page == 'normalized_weight') {
            return $this->normalized_weight($data_view);
        } else if ($page == 'ideal_solutions') {
            return $this->normalized_weight($data_view, 'ideal_solutions');
        }
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
            return redirect()->to(base_url('topsis/' . $id_project . '/sub_criteria'));
        }
        
        $name = $this->request->getPost('name');
        if (!preg_match('/^[a-zA-Z0-9\s_.->=-]{3,}$/', $name)) {
            session()->setFlashdata('msg', "Illegal characters. Only letters, numbers, spaces, and hyphens are allowed. With atleast have 3 characters.");
            session()->setFlashdata('msg-type', 'warning');
            return redirect()->to(base_url('topsis/' . $id_project . '/criteria'));
        }

        // insert alternatives
        model('TopsisAlternatives')->insert([
            'name' => $name,
            'id_projects' => $id_project
        ]);
        $id_alternative = model('TopsisAlternatives')->insertID();

        // insert alternatives criteria weight
        foreach ($this->request->getPost('criteria') as $key => $c) {
            model('TopsisAlternativesSubCriteria')->insert([
                'id_topsis_alternatives' => $id_alternative,
                'id_topsis_criteria' => $c,
                'id_topsis_sub_criteria' => $this->request->getPost('crit_'.$c)
            ]);
        }

        session()->setFlashdata('msg', 'Successfully added a new alternative.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('topsis/' . $id_project . '/alternatives'));
    }

    function alternatives_delete($id_project, $id_alternative) {
        if(!$this->validate_project_access($id_project)) {
            return redirect()->to(base_url('/dashboard'));
        }
        $where = [
            'id_projects' => $id_project,
            'id' => $id_alternative
        ];

        model('TopsisAlternatives')->where($where)->delete();

        session()->setFlashdata('msg', 'Successfully deleted a alternative.');
        session()->setFlashdata('msg-type', 'success');
        return redirect()->to(base_url('topsis/' . $id_project . '/alternatives'));
    }

    function normalized($data_view) {
        $arr_sum_weight_squared = [];
        $arr_sum_weight_squared_text = [];
        foreach ($data_view['alternatives'] as $key => $a) :
            foreach ($data_view['criteria'] as $key_c => $c) {
                if ($key == 0) {
                    $arr_sum_weight_squared[$c['id']] = $data_view['alternatives_weight'][$a['id']][$c['id']]['weight'] ** 2;
                    $arr_sum_weight_squared_text[$c['id']] = '√('.$data_view['alternatives_weight'][$a['id']][$c['id']]['weight'].'² + ';
                } else {
                    $arr_sum_weight_squared[$c['id']] += $data_view['alternatives_weight'][$a['id']][$c['id']]['weight'] ** 2;
                    $arr_sum_weight_squared_text[$c['id']] .= $data_view['alternatives_weight'][$a['id']][$c['id']]['weight'].'² + ';
                }
            }
        endforeach;
        $data_view['arr_sum_weight_squared'] = $arr_sum_weight_squared;
        $data_view['arr_sum_weight_squared_text'] = $arr_sum_weight_squared_text;

        return view('dss/topsis/normalized', $data_view);
    }

    function normalized_weight($data_view, $next_function = '') {
        $arr_sum_weight_squared = [];
        foreach ($data_view['alternatives'] as $key => $a) :
            foreach ($data_view['criteria'] as $key_c => $c) {
                if ($key == 0) {
                    $arr_sum_weight_squared[$c['id']] = $data_view['alternatives_weight'][$a['id']][$c['id']]['weight'] ** 2;
                } else {
                    $arr_sum_weight_squared[$c['id']] += $data_view['alternatives_weight'][$a['id']][$c['id']]['weight'] ** 2;
                }
            }
        endforeach;
        $data_view['arr_sum_weight_squared'] = $arr_sum_weight_squared;
 
        foreach ($data_view['alternatives'] as $key => $a) :
            foreach ($data_view['criteria'] as $key_c => $c) {
                $data_view['normalized'][$a['id']][$c['id']] = $data_view['alternatives_weight'][$a['id']][$c['id']]['weight']/sqrt($arr_sum_weight_squared[$c['id']]);
            }
        endforeach;

        if ($next_function == 'ideal_solutions') {
            return $this->ideal_solutions($data_view);
        }

        return view('dss/topsis/normalized_weight', $data_view);
    }

    function ideal_solutions($data_view) {
        $arr_normalized_weight = [];
        $alternatives = $data_view['alternatives'];
        $alternatives_weight = $data_view['alternatives_weight'];
        $criteria = $data_view['criteria'];
        $total_criteria_weight = $data_view['criteria'];
        $normalized = $data_view['normalized'];

        foreach ($alternatives as $key => $a) :
                foreach ($criteria as $key_c => $c) {
                    $arr_normalized_weight[$c['id']][] =$c['weight']*$normalized[$a['id']][$c['id']];
                }
        endforeach;

        $arr_max = [];
        $arr_min = [];
        for ($i = 0; $i < count($criteria); $i++) {
            if ($criteria[$i]['cost_benefit'] == 'benefit') {
                $arr_max[$criteria[$i]['id']] = max($arr_normalized_weight[$criteria[$i]['id']]);
                $arr_min[$criteria[$i]['id']] = min($arr_normalized_weight[$criteria[$i]['id']]);
            } else {
                $arr_min[$criteria[$i]['id']] = max($arr_normalized_weight[$criteria[$i]['id']]);
                $arr_max[$criteria[$i]['id']] = min($arr_normalized_weight[$criteria[$i]['id']]);
            }
        }

        $d_plus_before_root = [];
        $d_plus_before_root_str = [];
        $d_min_before_root_str = [];
        $d_min_before_root = [];
        foreach ($alternatives as $key => $a) :
            foreach ($criteria as $key_c => $c) :
                if($key_c == 0) {
                    $d_plus_before_root[$a['id']] =($arr_max[$c['id']] - $arr_normalized_weight[$c['id']][$key])**2;
                    $d_plus_before_root_str[$a['id']] = "√((" . number_format($arr_max[$c['id']], 2) . "-" . number_format($arr_normalized_weight[$c['id']][$key], 2) . ")²+";
                    $d_min_before_root[$a['id']] = ($arr_min[$c['id']] - $arr_normalized_weight[$c['id']][$key])**2;
                    $d_min_before_root_str[$a['id']] = "√((" . number_format($arr_min[$c['id']], 2) . "-" . number_format($arr_normalized_weight[$c['id']][$key], 2) . ")²+";
                } else {
                    $d_plus_before_root[$a['id']] += ($arr_max[$c['id']] - $arr_normalized_weight[$c['id']][$key])**2;
                    $d_plus_before_root_str[$a['id']] .= "(" . number_format($arr_max[$c['id']], 2) . "-" . number_format($arr_normalized_weight[$c['id']][$key], 2) . ")²+";
                    $d_min_before_root[$a['id']] += ($arr_min[$c['id']] - $arr_normalized_weight[$c['id']][$key])**2;                    $d_min_before_root_str[$a['id']] .= "(" . number_format($arr_min[$c['id']], 2) . "-" . number_format($arr_normalized_weight[$c['id']][$key], 2) . ")²+";
                }
            endforeach;
            $d_min_before_root_str[$a['id']] = rtrim($d_min_before_root_str[$a['id']], '+') . ")";
            $d_plus_before_root_str[$a['id']] = rtrim($d_plus_before_root_str[$a['id']], '+') . ")";
        endforeach;

        $data_view['arr_min'] = $arr_min;
        $data_view['arr_max'] = $arr_max;
        $data_view['d_plus_before_root'] = $d_plus_before_root;
        $data_view['d_min_before_root'] = $d_min_before_root;
        $data_view['d_plus_before_root_str'] = $d_plus_before_root_str;
        $data_view['d_min_before_root_str'] = $d_min_before_root_str;

        return view('dss/topsis/ideal_solutions', $data_view); 
    }
}
