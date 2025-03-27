<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class Session
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('id')){
            $id = $request->session()->get('id');
            $user = DB::table('users')->where('id', $id)->select('*')->get();
            if (count($user) > 0){
                $u = $user->first();
                unset($u->password);
                $request->session()->put('user', $u);
            } else {
                $request->session()->flush();
            }
        }
        $env = \Config::get('values.APP_ENV');
        $get_url_separator = DB::table('url_separator')->where('env', $env)->select('*')->get()->first();
        $request->session()->put('url_separator', $get_url_separator->separator);
        return $next($request);
    }
}
