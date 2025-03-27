<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['session', 'ceklogin']);
    }

    public function portal (Request $request){
        return view('portal.portal');
    }
}
