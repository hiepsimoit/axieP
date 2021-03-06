<?php

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use URL;
use DateTime;
use DB;
use App\balance_eod;
use App\investor;

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
        //chay l???i sau 5 ph??t
    }
    
}
