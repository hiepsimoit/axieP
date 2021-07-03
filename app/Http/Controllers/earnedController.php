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


class earnedController extends Controller
{
    public function getSLPearnedPerDay(Request $request){
        if($request->choose_month)
            $monthFull = substr($request->choose_month, 3,4).substr($request->choose_month, 0,2);
        else
            $monthFull = date('Ym');
        // echo $request->link;die;
        set_time_limit(0);

        $month = intval(substr($request->choose_month, 0, 2));
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

        $investor = investor::where('link', $request->link)->first();

        // dd($investor);die;

        if($investor)
            $investor_id = $investor->id; 
        else
            $investor_id = 1;
        $accounts = DB::table('accounts')->where('investor_id', $investor_id)->get();

        $table = [];
        $sum = [];
        $sumAll = 0;
        // $sumVertical = [];
        for($i = 0; $i<count($accounts);$i++){
            $sum[] = 0;
        }
        for($i = 0; $i < $numberDay; $i++){
            // $sumVertical[] = 0;
            if($i + 1 != $today || $monthFull != date('Ym')){ ///Các ngày khác
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
            else if($i + 1 == $today && $monthFull == date('Ym')){           //Ngày hôm nay (chưa ghi vào DB)
                $earned = [];
                $acc_index = 0;
                $sumVertical = 0;
                foreach ($accounts as $acc) {
                    $address = str_replace('ronin:', '0x', $acc->metamask);
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
                        if($bal_yesterday)
                            $curEarned = $curBalance - $bal_yesterday->balance;
                        else
                            $curEarned = $curBalance;
                        $earned[] = $curEarned;
                        $sum[$acc_index] += $curEarned;
                        $sumVertical += $curEarned;
                        // if($acc->id == 20){
                        //     echo $curBalance.'<br>'.$bal_yesterday->balance;die;
                        // }
                    }
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
            'month'=>$request->choose_month,
            'link'=>$request->link,
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
        $accounts = DB::table('accounts')->get();
        foreach ($accounts as $acc) {
            $url = "https://lunacia.skymavis.com/game-api/clients/".$acc->metamask."/items/1";
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
                    $earned = new balance_eod();
                    $earned->investor_id = $acc->investor_id;
                    $earned->acc_id = $acc->id;
                    $earned->month_id = date("Ym");
                    $earned->day = date("d");
                    if($bal_yesterday)
                        $earned->earned = $curBalance - $bal_yesterday->balance;
                    else
                        $earned->earned = $curBalance;
                    $earned->balance = $curBalance;
                    $earned->save();
                } else{
                    if($bal_yesterday)
                        $bal_today->earned = $curBalance - $bal_yesterday->balance;
                    else
                        $bal_today->earned = $curBalance;
                    $bal_today->balance = $curBalance;
                    $bal_today->save();
                }
            }
            else{
                //chay lại sau 5 phút
            }
            
        }
        
    }
}
