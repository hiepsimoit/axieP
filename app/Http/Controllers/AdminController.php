<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    protected function render($view_file,$data, $url, $title)
    {

        return view($view_file,['data'=>$data,'url'=>$url,'title'=>$title]);
    }
}
