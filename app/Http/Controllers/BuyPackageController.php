<?php

namespace App\Http\Controllers;

use App\account;
use App\buy_package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class BuyPackageController extends Controller
{
    //
    public function __construct()
    {
        $this->title = ' gói sử dụng';
        $this->url = 'buy_package';
    }

    public function index(Request $request){
        $input = $request->all();

        $investor_id = Auth::user()->id;
        $data = DB::table('buy_packages')
            ->select('buy_packages.*')
            ->where('buy_packages.investor_id',$investor_id)
            ->orderBy('buy_packages.id', 'DESC')
            ->paginate(20);

        return view( $this->url . '.index', ['data' => $data,'input' => $input, 'title' => "Quản lý " . $this->title, 'url' => $this->url]);
    }
    public  function add(){
        return view($this->url . '.add', ['title' => "Mua gói sử dụng" , 'url' => $this->url]);
    }
    public function postAdd(Request $request){
        $this->validate($request, [
            'package' => "required|not_in:0",
        ], [
                'package.required' => 'Bạn phải chọn gói',
                'package.not_in' => 'Gói phải khác 0',
            ]
        );
        $package  = $request->package;
        $investor_id = Auth::user();
        $data = account::where('investor_id',$investor_id->id)->where('status',1)->get();
        $number =  count($data);

        if($package != 180){
            $total = 5 * $number;
        }else {
            $total = 5 * $number*0.75;
        }
        $code = random_int(1000,9999);
        $new = new buy_package();
        $new->investor_id = $investor_id->id;
        $new->status = 0;
        $new->number_acc = $number;
        $new->total_price = $total;
        $new->package = $package;
        $new->code = $code;
        $new->save();
        return redirect($this->url)->with('message', 'Mua thành công với mã chuyển tiền '.$code);
    }

    public function getTotalBuyPackage(Request $request){
        $package  = $request->package;
        $investor_id = Auth::user();
        $data = account::where('investor_id',$investor_id->id)->where('status',1)->get();
        $number =  count($data);

        if($package != 180){
            $total = 5 * $number;
        }else {
            $total = 5 * $number*0.75;
        }

        return response()->json(['result' => number_format($total) .' USD']);
    }

}
