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

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\Events\Registered;



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


        
        // dd($table);

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
        set_time_limit(0);

        $accounts = account::get();
        $isError = 0;
        foreach ($accounts as $acc) {
            $address = str_replace('ronin:','0x',$acc->ronin);

            $day_yesterday = date('d',strtotime("-1 days"));
            $month_yesterday = date('Ym',strtotime("-1 days"));
            $day_yesyesterday = date('d',strtotime("-2 days"));
            $month_yesyesterday = date('Ym',strtotime("-2 days"));
            $bal_yesterday = balance_eod::where('acc_id', $acc->id)->where('month_id', $month_yesterday)->where('day', $day_yesterday)->first();
            $bal_yesyesterday = balance_eod::where('acc_id', $acc->id)->where('month_id', $month_yesyesterday)->where('day', $day_yesyesterday)->first();
            $bal_today = balance_eod::where('acc_id', $acc->id)->where('month_id', date('Ym'))->where('day', date('d'))->first();

            if(!$bal_today){
                $bal_today = new balance_eod();
                $bal_today->investor_id = $acc->investor_id;
                $bal_today->acc_id = $acc->id;
                $bal_today->month_id = date("Ym");
                $bal_today->day = date("d");
                
                if(!$bal_yesterday){
                    // $bal_today->earned = $curBalance;
                    $bal_yesterday = new balance_eod();
                    $bal_yesterday->investor_id = $acc->investor_id;
                    $bal_yesterday->acc_id = $acc->id;
                    $bal_yesterday->month_id = date("Ym", strtotime("-1 days"));
                    $bal_yesterday->day = date("d", strtotime("-1 days"));
                    $bal_yesterday->earned = 0;
                    if($bal_yesyesterday){
                        $bal_yesterday->balance = $bal_yesyesterday->balance;
                    }
                    else{
                        $bal_yesterday->balance = 0;
                    }

                    $bal_yesterday->save();
                }
                $bal_today->balance = $bal_yesterday->balance;
                $bal_today->earned = 0;
                $bal_today->save();
                // echo 1;die;
            } 
            else{ //ĐÃ tồn tại dữ liệu ngày hôm nay
                $url = "https://game-api.skymavis.com/game-api/clients/".$address."/items/1";
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,     // return web page
                    CURLOPT_HEADER         => false,    // don't return headers
                    CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                    CURLOPT_ENCODING       => "",       // handle all encodings
                    CURLOPT_USERAGENT      => "spider", // who am i
                    CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                    CURLOPT_CONNECTTIMEOUT => 30,      // timeout on connect
                    CURLOPT_TIMEOUT        => 30,      // timeout on response
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
                    $acc_id = $acc->id;
                    $curBalance = intval($res->total);
                    // $totalSLP += $curBalance;
                    $claimable = intval($res->claimable_total);
                    $last_claimed = $res->last_claimed_item_at;
                    $acc->claimable = $claimable;
                    $acc->total = $curBalance;
                    $acc->last_claimed = $last_claimed;
                    
                    $now = time(); // or your date as well
                    $datediff = $now - $last_claimed;
                    $datediff = round($datediff / (60 * 60 * 24));
                    if($datediff != 0)
                        $everage = round(($curBalance - $claimable) / $datediff);
                    else
                        $everage = 0;
                    $acc->everage = $everage;
                    $acc->save();

                    // $curBalance = intval($res->total);
                    
                    if($bal_yesterday){
                        // if($bal_today->acc_id == 7)
                        //     dd($bal_today);die;
                        $earnTemp = $curBalance - $bal_today->balance;
                        if($earnTemp >= 0){
                            $bal_today->earned += $earnTemp;
                            // $acc->balance = $curBalance;
                            // $acc->save();
                        }
                        else{
                            // $diff = 
                            if($curBalance < 200)
                                $bal_today->earned += $curBalance;
                        } 
                    }
                    else
                        $bal_today->earned = $curBalance;
                    $bal_today->balance = $curBalance;
                    $bal_today->save();
                }
                else{
                    $isError = 1;
                }
            }
            
        }
        if($isError)
            DB::table('logs')->insert(['action'=>date('Y-m-d H:i:s').' - Get SLP - ERROR!']);
        else
            DB::table('logs')->insert(['action'=>date('Y-m-d H:i:s').' - Get SLP - DONE!']);
    }

    public function getServerStatus(){
        set_time_limit(0);

        $url = "https://axie.zone:3000/server_status";
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
            $lastStatus = DB::table('server_status')->max('id');
            if($lastStatus){
                if($lastStatus->status <= 0)
                    $lastStatusIsOK = 0;
                else
                    $lastStatusIsOK = 1;

                $isOK = 0;
                // $isChange = 0;
                // dd($res);
                // echo 1;
                // echo $res->status_battles;die;
                if(intval($res->status_battles) <= 0){
                    $isOK = 0;
                    if($isOK != $lastStatusIsOK){
                        // $link  = url('register/confirm/'.$encrypted);
                        Mail::send([], [], function ($message) {
                            $message->to('quangtung1412@gmail.com')
                           //   $message->to('daotung253@gmail.com')
                            ->from('quangtung1412@gmail.com', 'Phạm Quang Tùng')
                            ->subject('Axie Battle Status' )
                            ->setBody('Server đang down! Không chơi được đâu!');
                        });
                        // echo 'Đã gửi mail: '.$res->status_battles;die;
                    }
                    
                }
                else{
                    $isOK = 1;
                    // $link  = url('register/confirm/'.$encrypted);
                    if($isOK != $lastStatusIsOK){
                        Mail::send([], [], function ($message) {
                            $message->to('quangtung1412@gmail.com')
                           //   $message->to('daotung253@gmail.com')
                            ->from('quangtung1412@gmail.com', 'Phạm Quang Tùng')
                            ->subject('Axie Battle Status' )
                            ->setBody('Server đang ngon vào cày đi!');
                        });
                    }
                    // echo 'Đã gửi mail: '.$res->status_battles;die;
                }
            }

            else{
                if(intval($res->status_battles) <= 0)
                    $isOK = 0;
                else 
                    $isOK = 1;
                DB::table('server_status')->insert(['status'=>$isOK]);
            }

        }
    }
}
