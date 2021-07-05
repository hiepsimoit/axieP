<?php

namespace App\Http\Controllers\Admin;

use App\admin_user;
use App\investor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->url = 'admin_user';
        $this->titlePage = 'admin User';
    }

    public function index()
    {
        //
        $data = admin_user::all();
        return view('admin.'.$this->url.'.index',['data'=>$data,'url'=>$this->url,'title'=>$this->titlePage]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.'.$this->url.'.add',['url'=>$this->url,'title'=>$this->titlePage]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'username' => 'required|max:50',
            'password' => 'min:6|required_with:rePassword|same:rePassword',
            'rePassword' => 'min:6'
        ], [

            ]
        );
        $admin_user = new admin_user();
        $admin_user->username = $request->username;
        $admin_user->password = bcrypt($request['password']);
        $admin_user->save();
        return redirect('admin/'.$this->url)->with('message','Thêm thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo 2;
        echo 1;die;
        //
      //  $data =admin_user::find($id);
       // return view('admin.'.$this->url.'.show1',['data'=>$data,'url'=>$this->url,'title'=>$this->titlePage]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data =admin_user::find($id);
        return view('admin.'.$this->url.'.edit',['data'=>$data,'url'=>$this->url,'title'=>$this->titlePage]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'password' => 'min:6|required_with:rePassword|same:rePassword',
            'rePassword' => 'min:6'
        ], [

            ]
        );
        $admin_user = admin_user::find($id);
        $admin_user->username = $request->username;
        $admin_user->password = bcrypt($request['password']);
        $admin_user->save();
        return redirect('admin/'.$this->url)->with('message','Thêm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $admin_user = admin_user::find($id);
        $admin_user->active = 0;
       $admin_user->save();
        return redirect('admin/'.$this->url)->with('message','Thêm thành công!');
    }
    public function adminLogout(){
        Auth::guard('admin')->logout();
        Auth::logout();
        return redirect('');
    }

    public function change(){
        $user = Auth::user();
        return view('admin.'.$this->url.'.changePass',['data'=>$user,'url'=>$this->url,'title'=>$this->titlePage]);
    }

    public function postChange(Request $request){
        $this->validate($request, [
            'oldPassword' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',

        ], [
                'oldPassword.required' => 'Bạn phải nhập mật khẩu cũ',
                'password.required' => 'Bạn phải nhập mật khẩu mới',
            ]
        );
        if (!(Hash::check($request->oldPassword, Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        $user = Auth::user();
        $admin_user = admin_user::find($user->id);
        $admin_user->password = bcrypt($request['password']);
        $admin_user->save();
    }
}


