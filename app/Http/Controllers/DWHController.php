<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DWHController extends Controller
{
    public function __construct()
    {
        $this->middleware(['session', 'ceklogin']);
    }
    
    public function dashboard_dwh (Request $request){
        return view('dwh.dashboard_dwh');
    }
}
