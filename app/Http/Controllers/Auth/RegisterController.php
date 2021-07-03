<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\investor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:investors',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
         investor::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'status' => 0,
            'password' => bcrypt($data['password']),
        ]);

        Mail::send([], [], function ($message) use ($data) {

            $message->to($data['email'])
                //  $message->to('daotung253@gmail.com')
                ->from('nganq2710@gmail.com', 'Nguyễn Thị Quỳnh Nga')
                ->subject('Kích hoạt tài khoản _' . $data['name'] . ' tại Axie ' )
                ->setBody('<b>Thân chào  ' . $data['name'] . '!!</b><br><br/>Vui lòng vào
 <a href=""> click vào link</a>để kích 
hoạt tài khoản.<br/>Mọi thắc mắc hoặc yêu cầu hỗ trợ xin liên hệ::<br/>Trân trọng,<br/>', 'text/html');
        });

    }
}
