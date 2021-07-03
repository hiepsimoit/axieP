<?php

namespace App\Http\Controllers;

use App\staff;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StaffController extends Controller
{
    //
    public function __construct()
    {
        $this->title = ' người chơi';
        $this->url = 'staff';
    }

    public function index(Request $request){
        $input = $request->all();
        $name = $request->name;
        $investor_id = Auth::user()->id;
        $data = DB::table('staffs')
            ->select('staffs.*')
            ->where(function ($query) use ($name) {
                if ($name) {
                    $query->where('staffs.name', 'like', '%' . $name . '%');
                }
            })
            ->where('staffs.investor_id',$investor_id)
            ->orderBy('staffs.id', 'DESC')
            ->paginate(20);

        return view( $this->url . '.index', ['data' => $data,'input' => $input, 'title' => "Quản lý " . $this->title, 'url' => $this->url]);
    }
    public  function add(){
        return view($this->url . '.add', ['title' => "Tạo " . $this->title, 'url' => $this->url]);
    }

    public function postAdd(Request $request)
    {

        $this->validate($request, [
            'name' => "required|max:255",
            'bank_acc' => "required|max:255",
            'bank_name' => "required|max:255",
            'salary' => "required|max:255",
        ], [
                'name.required' => 'Bạn phải nhập tên',
                'bank_acc.required' => 'Bạn phải nhập số tài khoản',
                'bank_name.required' => 'Bạn phải nhập ngân hàng',
                'salary.required' => 'Bạn phải nhập lương',
                'salary.max' => 'Lương tối đa 255 kí tự',
                'bank_name.max' => 'Ngân hàng tối đa 255 kí tự',
                'bank_acc.max' => 'Số tài khoản tối đa 255 kí tự',
                'name.max' => 'Tên tối đa 255 kí tự',
            ]
        );

        $newStaff = new staff();
        $newStaff->name = $request->name;
        $newStaff->bank_acc = $request->bank_acc;
        $newStaff->bank_name = $request->bank_name;
        $newStaff->salary = str_replace('.','',$request->salary);
          $user = Auth::user();
        $newStaff->investor_id = $user->id;
        $newStaff->status = 1;
        $newStaff->save();
        return redirect($this->url)->with('message', 'Tạo thành công!');

    }
    public  function edit($id){
        $data = staff::find($id);
        $user = Auth::user();
        if($data->investor_id == $user->id){
            return view($this->url . '.edit', ['data'=>$data,'title' => "Sửa " . $this->title, 'url' => $this->url]);
        }

    }

    public function postEdit(Request $request,$id)
    {
        $data = staff::find($id);
        $user = Auth::user();
        if($data->investor_id == $user->id) {
            $this->validate($request, [
                'name' => "required|max:255",
                'bank_acc' => "required|max:255",
                'bank_name' => "required|max:255",
                'salary' => "required|max:255",
            ], [
                    'name.required' => 'Bạn phải nhập tên',
                    'bank_acc.required' => 'Bạn phải nhập số tài khoản',
                    'bank_name.required' => 'Bạn phải nhập ngân hàng',
                    'salary.required' => 'Bạn phải nhập lương',
                    'salary.max' => 'Lương tối đa 255 kí tự',
                    'bank_name.max' => 'Ngân hàng tối đa 255 kí tự',
                    'bank_acc.max' => 'Số tài khoản tối đa 255 kí tự',
                    'name.max' => 'Tên tối đa 255 kí tự',
                ]
            );

            $newStaff = staff::find($id);
            $newStaff->name = $request->name;
            $newStaff->bank_acc = $request->bank_acc;
            $newStaff->bank_name = $request->bank_name;
            $newStaff->salary = str_replace('.', '', $request->salary);
            $user = Auth::user();
            $newStaff->investor_id = $user->id;

            $newStaff->save();
            return redirect($this->url)->with('message', 'Sửa thành công!');
        }

    }

    public  function delete($id){
        $data = staff::find($id);
        $user = Auth::user();
        if($data->investor_id == $user->id){
            $data->status = -1;
            $data->save();
            return redirect($this->url)->with('message', 'Xóa thành công!');
        }

    }

}
