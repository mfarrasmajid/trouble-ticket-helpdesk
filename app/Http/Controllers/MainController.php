<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['session', 'ceklogin']);
    }

    public function cleansing_no_telp($no_telp){
        $a = substr($no_telp, 0, 1);
        $aa = substr($no_telp, 0, 2);
        if ($a == '0'){
            return '62'.substr($no_telp, 1);
        } else if ($a == '8'){
            return '62'.$no_telp;
        } else if ($aa == '62'){
            return $no_telp;
        } else {
            return '62'.substr($no_telp, 2);
        }
    }
    
    public function get_ip(){
        $url = \Config::get('values.WHATSAPP_API_URL');
        $response = Http::timeout(10)->get($url.'/ip');
        return $response;
    }

    public function test_wa_notif (){
        $url = \Config::get('values.WHATSAPP_API_URL');
        $user = \Config::get('values.WHATSAPP_API_USER');
        $no_telp = $this->cleansing_no_telp('082115464605');
        // $image_path = str_replace('\\', '/', url('public/assets/_it/wa-logo.jpg'));
        $image_path = "https://it-oneflux.mitratel.co.id/public/assets/_it/wa-logo.jpg";
        $message = "*TEST NOTIF*

Test aja";
        $token = \Config::get('values.WHATSAPP_TOKEN');;
        $response = Http::timeout(10)->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->post($url.'/'.$user.'/send_message', [
            'number' => $no_telp,
            'type' => 'image',
            'image' => $image_path,
            'message' => $message
        ]);
        return $response;
    }

    public function init_send_credentials_dashboard (Request $request){
        $url = \Config::get('values.WHATSAPP_API_URL');
        $user = \Config::get('values.WHATSAPP_API_USER');
        $no_telp = $this->cleansing_no_telp('082115464605');
        // $image_path = str_replace('\\', '/', url('public/assets/_it/wa-logo.jpg'));
        $image_path = "https://statik.tempo.co/data/2021/11/22/id_1068305/1068305_720.jpg";
        $data['nomor_sl'] = [
            '6282115464605'
        ];
        $data['nama_sl'] = [
            'Farras'
        ];
        $token = \Config::get('values.WHATSAPP_TOKEN');
        foreach($data['nomor_sl'] as $key => $nomor){
            $message = "*TEST NOTIF*

Selamat malam ".$data['nama_sl'][$key];
            $response = Http::timeout(10)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->post($url.'/'.$user.'/send_message', [
                'number' => $nomor,
                'type' => 'image',
                'image' => $image_path,
                'message' => $message
            ]);
        }
        // return $response;
        
        return 1;
    }

    public function portal (Request $request){
        return view('portal.portal');
    }
}
