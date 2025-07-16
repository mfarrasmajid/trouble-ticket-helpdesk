<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekDWH
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
        $u = $request->session()->get('user');
        if (($u->privilege == 'ADMIN') || ($u->privilege == 'USER')){
            return $next($request);
        } else {
            return redirect()->route('portal')->with('error', 'Anda tidak berhak mengakses halaman ini!');
        }
    }
}
