<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\setting;

class AdminSettingController extends Controller
{
    //
    public function __construct()
    {
        $this->url = 'setting';
        $this->titlePage = 'Cài đặt';
    }

    public function index(){
        $data = setting::find(1);
        return view('admin.'.$this->url.'.index',['data'=>$data,'url'=>$this->url,'title'=>$this->titlePage]);
    }
    public function postSetting(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'required|max:255',

        ], [

            ]
        );

        $setting = setting::find(1);
        $setting->name = $request->name;
        $setting->address = $request->address;
        $setting->save();
        return redirect('admin/'.$this->url)->with('message', 'Tạo thành công!');
    }
}
