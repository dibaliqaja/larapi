<?php

namespace App\Http\Controllers;

use App\Cities;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    public function index()
    {
        // $logs = LogActivity::logActivityLists();
        $logs = DB::table('log_activity')
                ->select('log_activity.subject as subject', 'log_activity.url as url', 'log_activity.method as method', 'log_activity.ip as ip', 'log_activity.agent as agent', 'users.email as name')
                ->leftJoin('users', 'log_activity.user_id', '=', 'users.id')
                ->orderBy('log_activity.id', 'DESC')->paginate(5);

        return view('logs', compact('logs'));
    }

    public function listCities($idprovince){
        $city = Cities::select('city_code','city_name')->where("province_code", $idprovince)->get();
        return response()->json($city);
    }
}
