<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SimpleAdditiveWeighting extends BaseController
{
    public function index()
    {
        $data_view = [
            'title' => 'Simple Additive Weighting',
            'page_master' => 'saw',
            'page_sub' => 'saw-index'
        ];
        return view('dss/saw/index', $data_view);
    }
}
