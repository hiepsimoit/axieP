<?php

namespace App\Http\Controllers;

use App\staff;
use Illuminate\Http\Request;
use DB;
use App\account;
use App\rewards;
use Illuminate\Support\Facades\Auth;
use DomDocument;

class rewardsController extends Controller
{
    //

    public function get(Request $request){
        $vip_time = Auth::user()->vip_time;
        if(date('now') > $vip_time || !Auth::user()->paid){
            return view('buy_package.add', ['title' => "Mua gói sử dụng" , 'url' => 'buy_package'])->with('message', 'Thật tiếc! Gói VIP của bạn đã hết! Hãy mua thêm nhé!');
        }
        if($request->choose_month)
            $monthFull = substr($request->choose_month, 3, 4).substr($request->choose_month, 0, 2);
        else
            $monthFull = date('Ym');

        $user_id = Auth::user()->id;
        $staffs = staff::where('investor_id', $user_id)->where('status', 1)->orderBy('id', 'asc')->get();
        $accounts = account::where('investor_id', $user_id)->where('status', 1)->orderBy('id', 'asc')->get();
        $rewards = rewards::where('investor_id', $user_id)->where('month', $monthFull)->where('status',1)->get();

        // dd($rewards);

        return view('rewards',['staffs'=>$staffs, 'accounts'=>$accounts, 'choose_month'=>$request->choose_month, 'rewards'=>$rewards]);
    }


    public function postUpdateReward (Request $request){
        if($request->choose_month)
            $monthFull = substr($request->choose_month, 3, 4).substr($request->choose_month, 0, 2);
        else
            $monthFull = date('Ym');

        $acc = account::find($request->acc_id);
        if($acc){
            $reward = new rewards();
            $reward->investor_id = Auth::user()->id;
            $reward->staff_id = $acc->staff_id;
            $reward->acc_id = $acc->id;
            $reward->month = $monthFull;
            $reward->value = intval(str_replace(',', '',$request->reward));
            $reward->type = $request->reward_type;
            $reward->lydo = $request->lydo;
            $reward->status = 1;
            $reward->save();
        }

        $accs = account::where('staff_id', $acc->staff_id)->where('status', 1)->get();
        $staff = staff::find($acc->staff_id);

        $rewards = rewards::where('acc_id', $request->acc_id)->where('month', $monthFull)->where('status',1)->get();
        $totalReward = 0;
        foreach($rewards as $rw){
            if($rw->type == 1)
                $totalReward += $rw->value;
            else
                $totalReward -= $rw->value;
        }

        $totalIncome = $staff->salary * count($accs) + $totalReward;
        // return redirect('rewards')->with('message', 'Cập nhật thành công!');
        return response()->json(array('totalReward'=> $totalReward, 'acc_id'=>$acc->id, 'totalIncome'=>$totalIncome, 'staff_id'=>$staff->id));
    }
}
