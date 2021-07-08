<?php

namespace App\Http\Controllers;

use App\account;
use App\buy_package;
use App\buy_package_detail;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyPackageController extends Controller
{
    //
    public function __construct()
    {
        $this->title = ' gói sử dụng';
        $this->url = 'buy_package';
    }

    public function index(Request $request)
    {
        $input = $request->all();

        $investor_id = Auth::user()->id;
        $data = DB::table('buy_packages')
            ->select('buy_packages.*')
            ->where('buy_packages.investor_id', $investor_id)
            ->orderBy('buy_packages.id', 'DESC')
            ->paginate(20);

        return view($this->url . '.index', ['data' => $data, 'input' => $input, 'title' => "Quản lý " . $this->title, 'url' => $this->url]);
    }

    public function add()
    {
        $user = Auth::user();
        $dataAccount = account::where('investor_id', $user->id)
            ->where(function ($query) use ($user) {
                $query->whereNull('expiredDate')->orWhere('expiredDate', '<=', date('Ymd'));
            })
            ->where('isExpired', 0)
            ->where('status', 1)
            ->get();
        return view($this->url . '.add', ['title' => "Mua gói sử dụng", 'url' => $this->url, 'dataAccount' => $dataAccount]);
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'package' => "required|not_in:0",
            'select_status' => "required",
        ], [
                'package.required' => 'Bạn phải chọn gói',
                'package.not_in' => 'Gói phải khác 0',
            ]
        );
        $package = $request->package;
        $investor_id = Auth::user();
        $dataSend = $request->send;
        $select_status = $request->select_status;

        $arraySend = array();
        foreach ($select_status as $key => $item) {
            if ($item == 1) {
                array_push($arraySend, $dataSend[$key]);
            }
        }

        if(empty($arraySend)){
            echo 'Bạn phải chọn tài khoản mua';die;
        }

      //  $data = account::where('investor_id', $investor_id->id)->where('status', 1)->get();
        $number = count($arraySend);

        if ($package == 15) {
            $total = 2.5 * $number;
        } else if ($package == 30) {
            $total = 5 * $number;
        } else {
            $total = 5 * $number * 0.75 * 6;
        }
        $code = random_int(1000, 9999);
        $new = new buy_package();
        $new->investor_id = $investor_id->id;
        $new->status = 0;
        $new->number_acc = $number;
        $new->total_price = $total;
        $new->package = $package;
        $new->code = $code;
        $new->save();
        $buyId = $new->id;
        $nextDate =date('Ymd', strtotime(' + ' .$package.' days'));;
        if(!empty($arraySend)){
            foreach ($arraySend as $item){
                $account  = account::find($item);
                $account->isExpired = 0;
                $account->expiredDate = $nextDate;
                $account->save();
                $packageDetail = new buy_package_detail();
                $packageDetail->buy_id = $buyId;
                $packageDetail->account_id  =$item;
                $packageDetail->expiredDate = $nextDate;
                $packageDetail->status = 0;
                $packageDetail->save();
            }
        }
        return redirect($this->url)->with('message', 'Mua thành công với mã chuyển tiền ' . $code);
    }

    public function getTotalBuyPackage(Request $request)
    {
        $package = $request->package;
        $number = $request->total;

        if ($package == 15) {
            $total = 2.5 * $number;
        } else if ($package == 30) {
            $total = 5 * $number;
        } else {
            $total = 5 * $number * 0.75 * 6;
        }

        return response()->json(['result' => number_format($total) . ' USD']);
    }

}
