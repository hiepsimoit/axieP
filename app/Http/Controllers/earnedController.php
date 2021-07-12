<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use URL;
use DateTime;
use DB;
use App\balance_eod;
use App\investor;
use App\account;



class earnedController extends Controller
{
    public function getSLPearnedPerDay(Request $request){
        // dd(account::get());
        // echo date(strtotime('+30 days'));die;
        // echo $request->choose_month.'<br>'; 
        // echo date('m/Y');
        // die;
        // echo $request->link;die;

        $vip_time = Auth::user()->vip_time;

        if(date('now') > $vip_time || !Auth::user()->paid){
            return view('buy_package.add', ['title' => "Mua gói sử dụng" , 'url' => 'buy_package'])->with('message', 'Thật tiếc! Gói VIP của bạn đã hết! Hãy mua thêm nhé!');
        }

        if($request->choose_month)
            $monthFull = substr($request->choose_month, 3, 4).substr($request->choose_month, 0, 2);
        else
            $monthFull = date('Ym');

        // echo $monthFull;die;
        set_time_limit(0);

        $month = intval(substr($monthFull, 4, 6));
        $today = intval(date('d'));
        if(
            $month == 1 ||
            $month == 3 ||
            $month == 5 ||
            $month == 7 ||
            $month == 8 ||
            $month == 10 ||
            $month == 12
        )
            $numberDay = 31;
        else
            $numberDay = 30;

        // $investor = investor::where('link', $request->link)->first();

        // dd($investor);die;

        // if($investor)
        //     $investor_id = $investor->id; 
        // else
        //     $investor_id = 1;

        $accounts = account::where('investor_id', Auth::user()->id)->where('status', 1)->get();

        // dd($accounts);

        $table = [];
        $sum = [];
        $sumAll = 0;
        // $sumVertical = [];
        for($i = 0; $i<count($accounts);$i++){
            $sum[] = 0;
        }
        for($i = 0; $i < $numberDay; $i++){
            // $sumVertical[] = 0;
            if($i + 1 != $today){ ///Các ngày khác
                $earned = [];
                $acc_index = 0;
                $sumVertical = 0;
                foreach ($accounts as $acc) {
                    $earnPerDay = balance_eod::where('acc_id', $acc->id)->where('month_id', $monthFull)->where('day', $i+1)->first();
                    if($earnPerDay){
                        // dd($earnPerDay);die;
                        $earned[] = $earnPerDay->earned;
                        $sum[$acc_index] += $earnPerDay->earned;
                        $sumVertical += $earnPerDay->earned;
                    }
                    else{
                        $earned[] = 0;
                    }
                    $acc_index++;
                }
                $sumAll += $sumVertical;
                $earned[] = $sumVertical;
                $table[$i+1] = $earned;
            }
            else if($i+1 == $today && $monthFull == date('Ym')){           //Ngày hôm nay (chưa ghi vào DB)
                $earned = [];
                $acc_index = 0;
                $sumVertical = 0;
                foreach ($accounts as $acc) {
                    // $address = str_replace('ronin:', '0x', $acc->ronin);
                    // $url = "https://lunacia.skymavis.com/game-api/clients/".$address."/items/1";
                    // $options = array(
                    //     CURLOPT_RETURNTRANSFER => true,     // return web page
                    //     CURLOPT_HEADER         => false,    // don't return headers
                    //     CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                    //     CURLOPT_ENCODING       => "",       // handle all encodings
                    //     CURLOPT_USERAGENT      => "spider", // who am i
                    //     CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                    //     CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                    //     CURLOPT_TIMEOUT        => 120,      // timeout on response
                    //     CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
                    //     CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
                    // );

                    // $ch      = curl_init( $url );
                    // curl_setopt_array( $ch, $options );
                    // $content = curl_exec( $ch );
                    // $err     = curl_errno( $ch );
                    // $errmsg  = curl_error( $ch );
                    // $header  = curl_getinfo( $ch );
                    // curl_close( $ch );

                    // $header['errno']   = $err;
                    // $header['errmsg']  = $errmsg;
                    // $header['content'] = $content;
                    // // dd($header);
                    // $res = json_decode($header['content']);
                    // if($res){
                    //     // die;
                    //     // dd($res);die;
                    //     $curBalance = intval($res->total);
                    //     $claimable = intval($res->claimable_total);
                    //     $last_claimed = $res->last_claimed_item_at;
                    //     $acc->claimable = $claimable;
                    //     $acc->total = $curBalance;
                    //     $acc->last_claimed = $last_claimed;
                    //     $acc->save();

                    //     // echo $curBalance;die;
                    //     $day_yesterday = date('d',strtotime("-1 days"));
                    //     $month_yesterday = date('Ym',strtotime("-1 days"));
                    //     // $bal_yesterday = balance_eod::where('acc_id', $acc->id)->where('month_id', $month_yesterday)->where('day', $day_yesterday)->first();
                    //     $bal_today = balance_eod::where('acc_id', $acc->id)->where('month_id', date('Ym'))->where('day', date('d'))->first();
                    //     if($bal_today)
                    //         $curEarned = $bal_today->earned;
                    //     else{
                    //         // if($bal_yesterday){
                    //         //     $diff_bal = $curBalance - $bal_yesterday->balance;
                    //         //     if($diff_bal > 0)
                    //         //         $curEarned = $diff_bal;
                    //         //     else
                    //         //         $curEarned = 0;
                    //         // }
                    //         // else
                    //         //     $curEarned = $curBalance;
                    //         $curEarned = 0;
                    //     }
                        
                    //     $earned[] = $curEarned;
                    //     $sum[$acc_index] += $curEarned;
                    //     $sumVertical += $curEarned;
                    // }else{
                    //     $earned[] = "ERROR";
                    //     // $sum[$acc_index] += 0;
                    //     // $sumVertical += 0;
                    // }



                    $bal_today = balance_eod::where('acc_id', $acc->id)->where('month_id', date('Ym'))->where('day', date('d'))->first();
                    if($bal_today)
                        $curEarned = $bal_today->earned;
                    else{
                        // if($bal_yesterday){
                        //     $diff_bal = $curBalance - $bal_yesterday->balance;
                        //     if($diff_bal > 0)
                        //         $curEarned = $diff_bal;
                        //     else
                        //         $curEarned = 0;
                        // }
                        // else
                        //     $curEarned = $curBalance;
                        $curEarned = 0;
                    }
                    
                    $earned[] = $curEarned;
                    $sum[$acc_index] += $curEarned;
                    $sumVertical += $curEarned;
                    $acc_index++;
                }
                $sumAll += $sumVertical;
                $earned[] = $sumVertical;
                $table[$i+1] = $earned;
            }
        }
        $sum[] = $sumAll;
        $table['Tổng'] = $sum;


        
        // dd($table);die;

        return view('earned',[
            'accs'=>$accounts,
            'table'=>$table,
            // 'link'=>$request->link,
            'choose_month'=>$request->choose_month
        ]);
        
    }

    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->call(function () {
    //         $this->getSlpEndOfDay();
    //     })
    //     ->dailyAt('06:23')
    //     ->timezone('UTC')
    //     ->appendOutputTo('tasks.txt');
    // }

    public function getSlpEndOfDay(){
        // echo 1; die;
        set_time_limit(0);
        $accounts = account::get();
        $isError = 0;
        foreach ($accounts as $acc) {
            $address = str_replace('ronin:','0x',$acc->ronin);
            $url = "https://lunacia.skymavis.com/game-api/clients/".$address."/items/1";
            $options = array(
                CURLOPT_RETURNTRANSFER => true,     // return web page
                CURLOPT_HEADER         => false,    // don't return headers
                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                CURLOPT_ENCODING       => "",       // handle all encodings
                CURLOPT_USERAGENT      => "spider", // who am i
                CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                CURLOPT_TIMEOUT        => 120,      // timeout on response
                CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
                CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
            );

            $ch      = curl_init( $url );
            curl_setopt_array( $ch, $options );
            $content = curl_exec( $ch );
            $err     = curl_errno( $ch );
            $errmsg  = curl_error( $ch );
            $header  = curl_getinfo( $ch );
            curl_close( $ch );

            $header['errno']   = $err;
            $header['errmsg']  = $errmsg;
            $header['content'] = $content;
            // dd($header);
            $res = json_decode($header['content']);
            if($res){
                $curBalance = intval($res->total);
                $day_yesterday = date('d',strtotime("-1 days"));
                $month_yesterday = date('Ym',strtotime("-1 days"));
                $bal_yesterday = balance_eod::where('acc_id', $acc->id)->where('month_id', $month_yesterday)->where('day', $day_yesterday)->first();
                $bal_today = balance_eod::where('acc_id', $acc->id)->where('month_id', date('Ym'))->where('day', date('d'))->first();
                if(!$bal_today){
                    // echo 1; die;
                    $bal_today = new balance_eod();
                    $bal_today->investor_id = $acc->investor_id;
                    $bal_today->acc_id = $acc->id;
                    $bal_today->month_id = date("Ym");
                    $bal_today->day = date("d");
                    if($bal_yesterday){
                        $earnTemp = $curBalance - $bal_yesterday->balance;
                        if($earnTemp >= 0){
                            $bal_today->earned = $earnTemp;
                            // $acc->balance = $curBalance;
                            // $acc->save();
                        }
                        else{
                            $bal_today->earned = 0;
                            // $acc->balance = 0;
                            // $acc->save();
                        }

                    }
                    else{
                        $bal_today->earned = $curBalance;
                        // $acc->balance = $curBalance;
                        // $acc->save();
                    }
                    $bal_today->balance = $curBalance;
                    $bal_today->save();
                } else{
                    // echo 2; die;
                    if($bal_yesterday){
                        // echo $bal_today->acc_id."<br>";
                        // if($bal_today->acc_id == 7)
                        // {
                        //     // echo 1; die;
                        //     // dd($bal_today);
                        //     // echo $curBalance.'   '.$bal_today->balance.'   '. ($curBalance - $bal_today->balance); die;
                        // }
                        $earnTemp = $curBalance - $bal_today->balance;
                        if($earnTemp >= 0){
                            $bal_today->earned += $earnTemp;
                            // $acc->balance = $curBalance;
                            // $acc->save();
                        }
                        else{
                            // $diff = 
                            $bal_today->earned = $curBalance;
                        } 
                    }
                    else
                        $bal_today->earned = $curBalance;
                    $bal_today->balance = $curBalance;
                    $bal_today->save();
                }
            }
            else{
                $isError = 1;
            }
        }
        die;
        if($isError)
            DB::table('logs')->insert(['action'=>date('Y-m-d H:i:s').' - Get SLP - ERROR!']);
        else
            DB::table('logs')->insert(['action'=>date('Y-m-d H:i:s').' - Get SLP - DONE!']);
        
    }
}
