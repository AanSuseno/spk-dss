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
}
