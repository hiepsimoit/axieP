<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\investor;
use DB;
use Illuminate\Http\Request;

class AdminInvestorController extends Controller
{
    //
    public function __construct()
    {
        $this->url = 'investor';
        $this->titlePage = 'Investor ';
    }

    public function index(Request $request)
    {
        //
        $input = $request->all();
        $email = $request->email;
        $data = DB::table('investors')
            ->select('investors.*')
            ->where(function ($query) use ($email) {
                if ($email) {
                    $query->where('investors.email', 'like', '%' . $email . '%');
                }
            })
            ->orderBy('investors.id', 'DESC')
            ->paginate(20);

        return view('admin.' . $this->url . '.index', ['input' => $input, 'data' => $data, 'url' => $this->url, 'title' => $this->titlePage]);
    }

    public function delete($id)
    {
        $data = investor::find($id);
        $data->status = -1;
        $data->save();
        return redirect($this->url)->with('message', 'Xóa thành công!');

    }
    public function active($id)
    {
        $data = investor::find($id);
        $data->status = 1;
        $data->save();
        return redirect($this->url)->with('message', 'Active thành công!');

    }
}
