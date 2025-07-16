<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpdeskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['session', 'ceklogin']);
    }

    public function dashboard_helpdesk(Request $request){
        return view('helpdesk.dashboard_helpdesk');
    }
}
