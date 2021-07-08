<?php

namespace App\Http\Controllers;
use App\staff;
use Illuminate\Http\Request;
use DB;
use App\account;
use Illuminate\Support\Facades\Auth;
use DomDocument;
// use DOMNodeListIterator;

class AccountController extends Controller
{
    //

    public function __construct()
    {
        $this->title = ' tài khoản';
        $this->url = 'account';
    }

    public function index(Request $request){
        $input = $request->all();
        $name = $request->name;
        $investor_id = Auth::user()->id;
        $data = DB::table('accounts')
            ->select('accounts.*')
            ->where(function ($query) use ($name) {
                if ($name) {
                    $query->where('accounts.ronin', 'like', '%' . $name . '%');
                }
            })
            ->where('accounts.investor_id',$investor_id)
            ->orderBy('accounts.id', 'DESC')
            ->paginate(20);

        return view( $this->url . '.index', ['data' => $data,'input' => $input, 'title' => "Quản lý " . $this->title, 'url' => $this->url]);
    }
    public  function add(){
        $investor_id = Auth::user()->id;;
        $dataStaff = staff::where('investor_id',$investor_id)->get();
        return view($this->url . '.add', ['dataStaff'=>$dataStaff,'title' => "Tạo " . $this->title, 'url' => $this->url]);
    }

    public function postAdd(Request $request)
    {

        $this->validate($request, [
            'ronin' => "required|max:100",
            'acc_name' => "required|max:45",
            'staff_id' => "required|not_in:0",
        ], [
                'ronin.required' => 'Bạn phải nhập metamask',
                'staff_id.required' => 'Bạn phải chọn người chơi',
                'ronin.max' => 'Tên tối đa 100 kí tự',
            ]
        );

        $new = new account();
        $new->ronin = $request->ronin;
        $new->staff_id = $request->staff_id;
        $new->acc_name = $request->acc_name;
        $user = Auth::user();
        $new->investor_id = $user->id;
        $new->status = 1;
        $new->save();
        return redirect($this->url)->with('message', 'Tạo thành công!');

    }
    public  function edit($id){

        $data = account::find($id);
        $user = Auth::user();

        if($data->investor_id == $user->id){
            $dataStaff = staff::where('investor_id',$user->id)->get();
            return view($this->url . '.edit', ['dataStaff'=>$dataStaff,'data'=>$data,'title' => "Sửa " . $this->title, 'url' => $this->url]);
        }

    }

    public function postEdit(Request $request,$id)
    {
        $data = account::find($id);
        $user = Auth::user();
        if($data->investor_id == $user->id) {

            $this->validate($request, [
                'ronin' => "required|max:100",
                'acc_name' => "required|max:45",
                'staff_id' => "required|not_in:0",
            ], [
                    'ronin.required' => 'Bạn phải nhập metamask',
                    'ronin.max' => 'Tên tối đa 100 kí tự',
                    'acc_name.max' => 'Tên tối đa 45 kí tự',
                    'staff_id.required' => 'Bạn phải chọn người chơi',
                ]
            );
            $new = account::find($id);
            $new->ronin = $request->ronin;
            $new->staff_id = $request->staff_id;
            $new->acc_name = $request->acc_name;
            $user = Auth::user();
            $new->investor_id = $user->id;
            $new->save();
            return redirect($this->url)->with('message', 'Sửa thành công!');
        }

    }

    public  function delete($id){
        $data = account::find($id);
        $user = Auth::user();
        if($data->investor_id == $user->id){
            $data->status = -1;
            $data->save();
            return redirect($this->url)->with('message', 'Xóa thành công!');
        }

    }


    public function showAccountsInfo(Request $request){
        $vip_time = Auth::user()->vip_time;
        
        if(date('now') > $vip_time || !Auth::user()->paid){
            return view('buy_package.add', ['title' => "Mua gói sử dụng" , 'url' => 'buy_package'])->with('message', 'Thật tiếc! Gói VIP của bạn đã hết! Hãy mua thêm nhé!');
        }
        set_time_limit(0);
        
        $accs = account::join('staffs', 'staffs.id', '=', 'accounts.staff_id')
        ->select('staffs.name as staff_name', 'accounts.acc_name', 'accounts.ronin')
        ->where('accounts.investor_id', Auth::user()->id)
        ->where('accounts.status', 1)
        ->get();

        $table = [];
        foreach ($accs as $acc) {
            $info = [];

            $address = str_replace('ronin:', '0x', $acc->ronin);
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
                // die;
                // dd($res);die;
                $curBalance = intval($res->total);
                $claimable = intval($res->claimable_total);
                $last_claimed = $res->last_claimed_item_at;
                $acc->claimable = $claimable;
                $acc->total = $curBalance;
                $acc->last_claimed = $last_claimed;
                $acc->save();

                $info[] = $acc->staff_name;
                $info[] = $acc->acc_name;

                $now = time(); // or your date as well
                $datediff = $now - $last_claimed;
                $everage = round(($curBalance - $claimable) / (round($datediff / (60 * 60 * 24)) + 1));
                $info[] = $everage;

                $info[] = $claimable;
                $info[] = $curBalance - $claimable;
                $info[] = $curBalance;
                $info[] = date('H:i d/m/Y', $last_claimed);
                $info[] = date('H:i d/m/Y', $last_claimed + 60 * 60 * 24 * 15);

                // $info[] = $acc->staff_name;
                $url = 'https://axie.zone/leaderboard?ron_addr='.$address;
                $ch      = curl_init( $url );
                curl_setopt_array( $ch, $options );
                $content = curl_exec( $ch );
                $err     = curl_errno( $ch );
                $errmsg  = curl_error( $ch );
                $header  = curl_getinfo( $ch );
                curl_close( $ch );

                $dom = new DomDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($content);
                libxml_use_internal_errors(false);
                $highlighted = $dom->getElementsByTagName('td');
                $info[] = $highlighted[3]->textContent;

                $table[] = $info;
            }else{
                $earned[] = "ERROR";
                // $sum[$acc_index] += 0;
                // $sumVertical += 0;
            }
        }

        return view('account.acc_info', ['table'=>$table]);
    }
}
