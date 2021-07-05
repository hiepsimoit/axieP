<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends \App\Http\Controllers\AdminController
{
    //
    public function index(){
        return parent::render($view ='admin.home',$data=array(),$url= '',$title ='');
      //  return view('admin.home');
    }
}
