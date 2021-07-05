<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\investor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        return redirect(route('login'))->with('status', 'Vui lòng vào email xác nhận tài khoản');


        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
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

        $encrypted = Crypt::encryptString($data['email']);
        $link  = url('register/confirm/'.$encrypted);
            Mail::send([], [], function ($message) use ($data,$link) {
                $message->to($data['email'])
               //   $message->to('daotung253@gmail.com')
                ->from('quangtung1412@gmail.com', 'Phạm Quang Tùng')
                ->subject('Kích hoạt tài khoản ' . $data['name'] . ' tại Axie ' )
                ->setBody('<b>Thân chào  ' . $data['name'] . '!!</b><br><br/>Vui lòng vào
 <a href="'.$link.'"> click vào link</a>để kích
hoạt tài khoản.<br/>Mọi thắc mắc hoặc yêu cầu hỗ trợ xin liên hệ::0376.362.291<br/>Trân trọng,<br/>', 'text/html');
        });
            // die;
     return   investor::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'status' => 1,
            // 'paid'=> 1,
            // 'vip_time'=>strtotime('+ 5 days'),
            'password' => bcrypt($data['password']),
        ]);


    }
}
