<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login (Request $request) {
        if ($request->session()->has('id')){	
            return redirect()->route('portal');
        } else {
            $data = NULL;
            return view('auth.login', compact('data'));
        }
    }

    public function submit_login (Request $request){
        // $request->validate([
        //     'cf-turnstile-response' => ['required'], // token dari widget
        // ], [
        //     'cf-turnstile-response.required' => 'Captcha wajib diisi.',
        // ]);

        $verify = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret'   => config('services.turnstile.secret'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ])->json();

        if (!($verify['success'] ?? false)) {
            return back()
                ->withErrors(['cf_turnstile' => 'Verifikasi captcha gagal.'])
                ->withInput();
        }
        
        $input = $request->all();
        $datetime = date('Y-m-d H:i:s');
        $username = $input['username'];
        $password = $input['password'];
        $passwordmd5 = md5($input['password']);
        $url = "http://api.mitratel.co.id/ldap/telkom/api/apigwsit_v1.php";
        $postdata = http_build_query(
            array(
                'username' => $username,
                'password' => $password
            )
        );
        $option = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($option);
        $string = file_get_contents($url, false, $context);
        $json = json_decode($string,true);
        $status = $json['status']; // true / false

        if ($status){
            $check = DB::table('users')->where('nik_tg', $input['username'])
                                       ->select('*')
                                       ->get();
            if (count($check) > 0){
                $check = $check->first();
                if ($check->status_active){
                    $activity = 'Successful Login to DWH Monitoring From '.$input['username'];
                    $status = 'SUCCESS';
                    DB::table('log')->insert([
                        'nik_tg' => $input['username'],
                        'activity' => $activity,
                        'status' => $status,
                        'datetime' => $datetime
                    ]);
                    $request->session()->put('id', $check->id);
                    $last_login = DB::table('users')->where('id', $check->id)->update([
                        'last_login' => $datetime
                    ]);
                    return redirect()->route('portal');
                } else {
                    $activity = 'Unsuccessful Login to DWH Monitoring From '.$input['username'].', Inactive User';
                    $status = 'ERROR';
                    DB::table('log')->insert([
                        'nik_tg' => $input['username'],
                        'activity' => $activity,
                        'status' => $status,
                        'datetime' => $datetime
                    ]);
                    $message = 'User anda sudah tidak aktif lagi, mohon kontak admin IT apabila ada kekeliruan';
                    return redirect()->route('login')->with('error', $message);
                }
            } else {
                $message = 'User anda sudah tidak aktif lagi, mohon kontak admin IT apabila ada kekeliruan';
                return redirect()->route('login')->with('error', $message);
            }
        } else {
            $check = DB::table('users')->where('nik_tg', $username)
                                       ->orWhere('email', $username)
                                       ->select('*')
                                       ->get();

            if (count($check) > 0){
                $check = $check->first();
                // return $password;
                if (Hash::check($password, $check->password)){
                    if ($check->status_active){
                        $activity = 'Successful Login to DWH Monitoring From '.$input['username'];
                        $status = 'SUCCESS';
                        DB::table('log')->insert([
                            'nik_tg' => $input['username'],
                            'activity' => $activity,
                            'status' => $status,
                            'datetime' => $datetime
                        ]);
                        $request->session()->put('id', $check->id);
                        $last_login = DB::table('users')->where('id', $check->id)->update([
                            'last_login' => $datetime
                        ]);
                        return redirect()->route('portal');
                    } else {
                        $activity = 'Unsuccessful Login to DWH Monitoring From '.$input['username'].', Inactive User';
                        $status = 'ERROR';
                        DB::table('log')->insert([
                            'nik_tg' => $input['username'],
                            'activity' => $activity,
                            'status' => $status,
                            'datetime' => $datetime
                        ]);
                        $message = 'User anda sudah tidak aktif lagi, mohon kontak admin IT apabila ada kekeliruan';
                        return redirect()->route('login')->with('error', $message);
                    }
                } else {
                    $message = 'Username atau Password salah, mohon cek kembali password anda';
                    return redirect()->route('login')->with('error', $message);    
                }
            } else {
                $message = 'Username atau Password salah, mohon cek kembali password anda';
                return redirect()->route('login')->with('error', $message);
            }
        }
    }

    public function logout (Request $request) {
        if ($request->session()->has('id')){
            $id = $request->session()->get('id');
            $nik_tg = $request->session()->get('user')->nik_tg;
            $datetime = date('Y-m-d H:i:s');
            $activity = "Successful Logout From DWH Monitoring From Username ".$nik_tg;
            $status = "SUCCESS";
            $last_logout = DB::table('users')->where('id', $id)->update([
                'last_logout' => $datetime
            ]);
            $log = DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
            $request->session()->flush();
            return redirect()->route('login');
        } else if ($request->session()->has('id2')){
            $id = $request->session()->get('id2');
            $nik_tg = $request->session()->get('user')->nik_tg;
            $datetime = date('Y-m-d H:i:s');
            $activity = "Successful Logout External From DWH Monitoring From Username ".$nik_tg;
            $status = "SUCCESS";
            $last_logout = DB::table('users_external')->where('id', $id)->update([
                'last_logout' => $datetime
            ]);
            $log = DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
            $request->session()->flush();
            return redirect()->route('login');
        } else{
            return redirect()->route('login');
        }
    }
}
