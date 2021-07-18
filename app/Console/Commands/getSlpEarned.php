<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use URL;
use DateTime;
use DB;
use App\balance_eod;
use App\investor;
use App\account;

class getSlpEarned extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:SlpEarned';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get SLP earned yesterday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
                $day_yesterday = date('d',strtotime("-1 days"));
                $month_yesterday = date('Ym',strtotime("-1 days"));
                $bal_yesterday = balance_eod::where('acc_id', $acc->id)->where('month_id', $month_yesterday)->where('day', $day_yesterday)->first();
                $bal_today = balance_eod::where('acc_id', $acc->id)->where('month_id', date('Ym'))->where('day', date('d'))->first();
                if(!$bal_today){
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
                            $bal_today->earned += $curBalance;
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
        if($isError)
            DB::table('logs')->insert(['action'=>date('Y-m-d H:i:s').' - Get SLP - ERROR!']);
        else
            DB::table('logs')->insert(['action'=>date('Y-m-d H:i:s').' - Get SLP - DONE!']);

    }
}
