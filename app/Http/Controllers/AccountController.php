<?php

namespace App\Http\Controllers;
use App\staff;
use Illuminate\Http\Request;
use DB;
use App\account;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    //

    public function __construct()
    {
        $this->title = ' tài khoản';
        $this->url = 'account';
    }

    public function index(Request $request){
        $input = $request->all();
        $name = $request->name;
        $investor_id = Auth::user()->id;
        $data = DB::table('accounts')
            ->select('accounts.*')
            ->where(function ($query) use ($name) {
                if ($name) {
                    $query->where('accounts.ronin', 'like', '%' . $name . '%');
                }
            })
            ->where('accounts.investor_id',$investor_id)
            ->orderBy('accounts.id', 'DESC')
            ->paginate(20);

        return view( $this->url . '.index', ['data' => $data,'input' => $input, 'title' => "Quản lý " . $this->title, 'url' => $this->url]);
    }
    public  function add(){
        $investor_id = Auth::user()->id;;
        $dataStaff = staff::where('investor_id',$investor_id)->get();
        return view($this->url . '.add', ['dataStaff'=>$dataStaff,'title' => "Tạo " . $this->title, 'url' => $this->url]);
    }

    public function postAdd(Request $request)
    {

        $this->validate($request, [
            'ronin' => "required|max:100",
            'acc_name' => "required|max:45",
            'staff_id' => "required|not_in:0",
        ], [
                'ronin.required' => 'Bạn phải nhập metamask',
                'staff_id.required' => 'Bạn phải chọn người chơi',
                'ronin.max' => 'Tên tối đa 100 kí tự',
            ]
        );

        $new = new account();
        $new->ronin = $request->ronin;
        $new->staff_id = $request->staff_id;
        $new->acc_name = $request->acc_name;
        $user = Auth::user();
        $new->investor_id = $user->id;
        $new->status = 1;
        $new->save();
        return redirect($this->url)->with('message', 'Tạo thành công!');

    }
    public  function edit($id){

        $data = account::find($id);
        $user = Auth::user();

        if($data->investor_id == $user->id){
            $dataStaff = staff::where('investor_id',$user->id)->get();
            return view($this->url . '.edit', ['dataStaff'=>$dataStaff,'data'=>$data,'title' => "Sửa " . $this->title, 'url' => $this->url]);
        }

    }

    public function postEdit(Request $request,$id)
    {
        $data = account::find($id);
        $user = Auth::user();
        if($data->investor_id == $user->id) {

            $this->validate($request, [
                'ronin' => "required|max:100",
                'acc_name' => "required|max:45",
                'staff_id' => "required|not_in:0",
            ], [
                    'ronin.required' => 'Bạn phải nhập metamask',
                    'ronin.max' => 'Tên tối đa 100 kí tự',
                    'acc_name.max' => 'Tên tối đa 45 kí tự',
                    'staff_id.required' => 'Bạn phải chọn người chơi',
                ]
            );
            $new = account::find($id);
            $new->ronin = $request->ronin;
            $new->staff_id = $request->staff_id;
            $new->acc_name = $request->acc_name;
            $user = Auth::user();
            $new->investor_id = $user->id;
            $new->save();
            return redirect($this->url)->with('message', 'Sửa thành công!');
        }

    }

    public  function delete($id){
        $data = account::find($id);
        $user = Auth::user();
        if($data->investor_id == $user->id){
            $data->status = -1;
            $data->save();
            return redirect($this->url)->with('message', 'Xóa thành công!');
        }

    }
}
