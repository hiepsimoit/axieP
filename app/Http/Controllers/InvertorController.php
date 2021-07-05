<?php

namespace App\Http\Controllers;

use App\investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class InvertorController extends Controller
{
    //
    public function __construct()
    {
        $this->title = ' tài khoản';
        $this->url = '';
    }


    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function userInfo()
    {
        $user = Auth::user();
        return view($this->url . '.userInfo', ['data' => $user, 'title' => "Sửa " . $this->title, 'url' => $this->url]);
    }

    public function editUserInfo(Request $request)
    {
        $this->validate($request, [
            'name' => "required|max:100",
            'link' => "required|max:45",
            'phone' => "max:255",
        ], [
                'name.required' => 'Bạn phải nhập metamask',
                'link.required' => 'Bạn phải chọn người chơi',
                'name.max' => 'Tên tối đa 100 kí tự',
                'link.max' => 'Link tối đa 45 kí tự',
                'phone.max' => 'Phone tối đa 255 kí tự',
            ]
        );
        $user = Auth::user();
        $data = investor::find($user->id);
        $data->name = $request->name;
        $data->link = $request->link;
        $data->phone = $request->phone;
        $data->save();
        return redirect(url('userInfo'))->with('message', 'Cập nhập thành công!');
    }

    public function changePass()
    {
        return view($this->url . '.changePass', ['title' => "Đổi mật khẩu ", 'url' => $this->url]);
    }

    public function postChangePass(Request $request)
    {


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
        $data = $user::find($user->id);
        $data->password = bcrypt($data['password']);
        $data->save();
        return redirect(url('userInfo'))->with('message', 'Cập nhập thành công!');

    }

    public function confirm($email)
    {

        $decrypt = Crypt::decryptString($email);

        $user = investor::where('email', $decrypt);

        if ($user->count() > 0) {
            $user->update([
                'status' => 1,
            ]);
            $notification_status = 'Bạn đã xác nhận thành công';
        } else {
            $notification_status = 'Mã xác nhận không chính xác';
        }

        return redirect(route('login'))->with('status', $notification_status);
    }
}
