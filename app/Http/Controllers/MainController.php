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

//     public function cleansing_no_telp($no_telp){
//         $a = substr($no_telp, 0, 1);
//         $aa = substr($no_telp, 0, 2);
//         if ($a == '0'){
//             return '62'.substr($no_telp, 1);
//         } else if ($a == '8'){
//             return '62'.$no_telp;
//         } else if ($aa == '62'){
//             return $no_telp;
//         } else {
//             return '62'.substr($no_telp, 2);
//         }
//     }
    
//     public function get_ip(){
//         $url = \Config::get('values.WHATSAPP_API_URL');
//         $response = Http::timeout(10)->get($url.'/ip');
//         return $response;
//     }

//     public function test_wa_notif (){
//         $url = \Config::get('values.WHATSAPP_API_URL');
//         $user = \Config::get('values.WHATSAPP_API_USER');
//         $no_telp = $this->cleansing_no_telp('082115464605');
//         // $image_path = str_replace('\\', '/', url('public/assets/_it/wa-logo.jpg'));
//         $image_path = "https://it-oneflux.mitratel.co.id/public/assets/_it/wa-logo.jpg";
//         $message = "*TEST NOTIF*

// Test aja";
//         $token = \Config::get('values.WHATSAPP_TOKEN');;
//         $response = Http::timeout(10)->withHeaders([
//             'Authorization' => 'Bearer '.$token
//         ])->post($url.'/'.$user.'/send_message', [
//             'number' => $no_telp,
//             'type' => 'image',
//             'image' => $image_path,
//             'message' => $message
//         ]);
//         return $response;
//     }

//     public function init_send_credentials_dashboard (Request $request){
//         $url = \Config::get('values.WHATSAPP_API_URL');
//         $user = \Config::get('values.WHATSAPP_API_USER');
//         $no_telp = $this->cleansing_no_telp('082115464605');
//         // $image_path = str_replace('\\', '/', url('public/assets/_it/wa-logo.jpg'));
//         // $image_path = "https://statik.tempo.co/data/2021/11/22/id_1068305/1068305_720.jpg";
//         $data['nomor_sl'] = [
//             // '628129912374',
//             // '62811837080',
//             // '628121139994',
//             // '628114179225',
//             // '628118868686',
//             // '62811438966',
//             // '628129014343',
//             // '628118033349',
//             // '62811574220',
//             // '6281284519160',
//             // '6282139858144',
//             // '628112200870',
//             // '62811222829',
//             // '628123452425',
//             // '6285219039280',
//             // '628111855222',
//             // '628118841978',
//             // '628122001460',
//             // '6281211115758',
//             // '6281261410847',
//             // '628111929256',
//             // '628111623322',
//             // '6282113540313',
//             // '628129789820',
//             // '6281381823110',
//             // '62811306654',
//             // '628112291948',
//             // '6281310523003',
//             // '62811506000',
//             // '62811657031',
//             // '6281382828806',
//             // '628119124999',
//             // '6282118866695',
//             // '6281222470236'
//         ];
//         $data['nama_sl'] = [
//             // 'M. AYODYA SATRYA',
//             // 'RIZAL BIRUNI',
//             // 'FAUZAN IRFAN',
//             // 'YOVI EFIDORI',
//             // 'RUDI ALBERT',
//             // 'PRIBADI AGUS WAHYUDI',
//             // 'SAMUEL SAMSU',
//             // 'DEDHY SUSAMTO',
//             // 'YUSTINUS NURWIDYANTO',
//             // 'HERMANSYAH',
//             // 'VENANTIUS TRI HANDOKO',
//             // 'WURYANTO',
//             // 'JULIADI NUGRAHA',
//             // 'I GUSTI NGURAH PUTRA BANUAJI',
//             // 'ASYRAF THIRAFI RAMDHANI',
//             // 'ARVIAN PANDU WIRAWAN',
//             // 'ANDI SETIAWAN',
//             // 'RANI SIESARIA',
//             // 'I MADE RADITYA DWIPAYANA',
//             // 'RICKY PRISUKMA',
//             // 'KUNTO WIJAYANDANU',
//             // 'SHENDY ANGGA IRAWAN',
//             // 'MOHAMMAD ALI AKBAR',
//             // 'AHMAD ZAMRI',
//             // 'ALIF BAJARA',
//             // 'EDY SUSILO',
//             // 'ALEX ISKANDAR YAPIS',
//             // 'ALBERTUS HUGO',
//             // 'MELANY ULFA',
//             // 'SAHAT SAGALA',
//             // 'DWI MULYONO NUGROHO',
//             // 'RADITA ALI PUTRA',
//             // 'IWA KARTIWA',
//             // 'ANUNG ANENDITO'
//         ];
//         $data['username'] = [
//             // 'Accounting Management',
//             // 'Area Office Jabodetabeb & Jabar',
//             // 'Area Office Jawa Bali & Nusa Tenggara',
//             // 'Area Office Pamasuka',
//             // 'Area Office Sumatera',
//             // 'Asset Productivity',
//             // 'Asset Sustainability',
//             // 'Billing & Settlement',
//             // 'Construction & Project Management 1',
//             // 'Construction & Project Management 2',
//             // 'Corporate Office',
//             // 'Fiberization',
//             // 'Human Capital Management',
//             // 'Information & Technology',
//             // 'Internal Audit',
//             // 'Investment Financing & Controller',
//             // 'Investor Relation',
//             // 'Legal & Regulatory',
//             // 'Marketing Strategy & Analytics',
//             // 'Operation Management',
//             // 'Operation Support',
//             // 'Partnership',
//             // 'Procurement',
//             // 'Product Development',
//             // 'Program Management Office',
//             // 'PST',
//             // 'Risk Management',
//             // 'Sales 1',
//             // 'Sales 2',
//             // 'Sales 3',
//             // 'Solution Engineering',
//             // 'Strategic Investment Management',
//             // 'Strategy & Business Development',
//             // 'Treasury & Tax'
//         ];
//         $token = \Config::get('values.WHATSAPP_TOKEN');
//         // return count($data['nomor_sl']).' '.count($data['nama_sl']).' '.count($data['username']);
//         foreach($data['nomor_sl'] as $key => $nomor){
//             $message = "Semangat Pagi Bapak/Ibu Senior Leader Mitratel, Pak/Bu *".$data['nama_sl'][$key]."*, berikut kami kirimkan credentials akun untuk memonitor progress Program Peduli Asset 2025 di unit masing-masing. Dalam Program ini, Unit IT membuat Dashboard menggunakan Data Warehouse & Data Analytics sehingga dapat memberikan informasi yang mendetail bagi bapak/ ibu Senior Leader sekalian.

// Adapun credentials bapak/ ibu sebagai berikut (username isikan tanpa tanda petik):
// username : \"".$data['username'][$key]."\"
// password : Mitratel2025
// URL : dashboard.mitratel.co.id

// Demikian dashboard ini kami informasikan kepada bapak/ ibu Senior Leader Mitratel sebagai bahan untuk mengajak dan memotivasi dan Analisa terhadap rekan-rekan mitratelians di dalam unit bapak/ ibu

// Best Regards,


// Information & Technology";
//             $response = Http::timeout(10)->withHeaders([
//                 'Authorization' => 'Bearer '.$token
//             ])->post($url.'/'.$user.'/send_message', [
//                 'number' => $nomor,
//                 'type' => 'text',
//                 // 'image' => $image_path,
//                 'message' => $message
//             ]);
//         }
//         // return $response;
        
//         return 1;
//     }

    public function portal (Request $request){
        return view('portal.portal');
    }
}
