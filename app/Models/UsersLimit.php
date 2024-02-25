<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersLimit extends Model
{
    protected $table            = 'users_limit';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function max_project($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        return $this->where('id_users', $id_users)->first()['project'];
    }

    function total_project($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        return model('Projects')
        ->where(['id_users' => $id_users])
        ->countAllResults();
    }

    function total_criteria_1_dss($dss = '', $id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;
        $total = 0;

        if ($dss != '') {
            $total = model('Projects')
            ->join($dss . '_criteria c', 'c.id_projects = projects.id')
            ->where([
                'projects.id_users' => $id_users,
                'c.deleted_at < ' => '2000-01-01 00:00:00',
                'projects.deleted_at < ' => '2000-01-01 00:00:00',
            ])->countAllResults();
        }

        return $total;
    }

    function arr_total_projects($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        $dss = model('Projects')->dss();
        $arr_total = [];

        foreach ($dss as $key => $v) {
            $arr_total[$v['dss']] = model('Projects')->where([
                'id_users' => session()->get('id'),
                'dss' => $v['dss']
            ])->countAllResults();
        }

        return $arr_total;
    }

    function max_criteria($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        return $this->where('id_users', $id_users)->first()['criteria'];
    }

    function total_criteria($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;
        $dss = model('Projects')->dss();
        $total = 0;

        foreach ($dss as $key => $v) {
            $total += model('Projects')
                ->join($v['dss'] . '_criteria c', 'c.id_projects = projects.id')
                ->where([
                    'id_users' => $id_users,
                    'c.deleted_at < ' => '2000:01:01 00:00:00'
                ])
                ->countAllResults();
        }

        return $total;
    }

    function total_sub_criteria_1_dss($dss = '', $id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;
        $total = 0;

        if ($dss != '') {
            $total = model('Projects')
            ->join($dss . '_criteria c', 'c.id_projects = projects.id')
            ->join($dss . '_sub_criteria sc', "sc.id_{$dss}_criteria = c.id")
            ->where([
                'projects.id_users' => $id_users,
                'c.deleted_at < ' => '2000-01-01 00:00:00',
                'sc.deleted_at < ' => '2000-01-01 00:00:00',
                'projects.deleted_at < ' => '2000-01-01 00:00:00',
            ])->countAllResults();
        }

        return $total;
    }

    function arr_total_criteria($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        $dss = model('Projects')->dss();
        $arr_total = [];

        foreach ($dss as $key => $v) {
            $arr_total[$v['dss']] = $this->total_criteria_1_dss($v['dss']);
        }

        return $arr_total;
    }

    function total_sub_criteria($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        $dss = model('Projects')->dss();
        $total = 0;

        foreach ($dss as $key => $v) {
            if (in_array($v['dss'], ['smart'])) {
				continue;
			}
            $total += $this->total_sub_criteria_1_dss($v['dss']);
        }

        return $total;
    }

    function max_sub_criteria($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        return $this->where('id_users', $id_users)->first()['sub_criteria'];
    }

    function max_alternatives($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        return $this->where('id_users', $id_users)->first()['alternatives'];
    }

    function arr_total_sub_criteria($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        $dss = model('Projects')->dss();
        $arr_total = [];

        foreach ($dss as $key => $v) {
            $arr_total[$v['dss']] = $this->total_sub_criteria_1_dss($v['dss']);
        }

        return $arr_total;
    }

    function total_alternatives_1_dss($dss = '', $id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;
        $total = 0;

        if ($dss != '') {
            $total = model('Projects')
            ->join($dss . '_alternatives a', 'a.id_projects = projects.id')
            ->where([
                'projects.id_users' => $id_users,
                'a.deleted_at < ' => '2000-01-01 00:00:00',
                'projects.deleted_at < ' => '2000-01-01 00:00:00',
            ])->countAllResults();
        }

        return $total;
    }

    function arr_total_alternatives($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        $dss = model('Projects')->dss();
        $arr_total = [];

        foreach ($dss as $key => $v) {
            $arr_total[$v['dss']] = $this->total_alternatives_1_dss($v['dss']);
        }

        return $arr_total;
    }

    function total_alternatives($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        $dss = model('Projects')->dss();
        $total = 0;

        foreach ($dss as $key => $v) {
            $total += $this->total_alternatives_1_dss($v['dss']);
        }

        return $total;
    }

    function canCreateNewProject($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        if ($this->total_project() >= $this->max_project()) {
            return false;
        }

        return true;
    }

    function canCreateNewCriteria($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        if ($this->total_criteria() >= $this->max_criteria()) {
            return false;
        }

        return true;
    }

    function canCreateNewSubCriteria($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        if ($this->total_sub_criteria() >= $this->max_sub_criteria()) {
            return false;
        }

        return true;
    }

    function canCreateNewAlternative($id_users = -1) {
        $id_users = ($id_users == -1) ? session()->get('id') : $id_users;

        if ($this->total_alternatives() >= $this->max_alternatives()) {
            return false;
        }

        return true;
    }
}
