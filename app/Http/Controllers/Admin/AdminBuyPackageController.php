<?php

namespace App\Http\Controllers\Admin;

use App\buy_package;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdminBuyPackageController extends Controller
{
    //
    public function __construct()
    {
        $this->url = 'buy_package';
        $this->titlePage = 'Mua gói ';
    }

    public function index(Request $request)
    {
        //
        $input = $request->all();
        $email = $request->name;
        $data = DB::table('buy_packages')
            ->select('buy_packages.*','investors.email','investors.name')
            ->join('investors','buy_packages.investor_id','=','investors.id','left')
            ->where(function ($query) use ($email) {
                if ($email) {
                    $query->where('investors.email', 'like', '%' . $email . '%');
                }
            })
            ->orderBy('buy_packages.id', 'DESC')
            ->paginate(20);

        return view('admin.' . $this->url . '.index', ['input' => $input, 'data' => $data, 'url' => $this->url, 'title' => $this->titlePage]);
    }


    public function active($id)
    {

        $data = buy_package::find($id);
        $data->status = 1;
        $data->save();

        $getAccount= DB::table('buy_package_detail')
            ->where('buy_id',$id)
            ->distinct()
            ->pluck('account_id')->toArray();
        DB::table('accounts')->whereIn('id', $getAccount)->update(array('isExpired' => 1));

        return redirect('admin/buy_package')->with('message', 'Đã cộng thành công!');
    }

}
