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
            'page_sub' => $dss . "-project"
        ];
        return view('dss/project', $data_view);
    }
}
