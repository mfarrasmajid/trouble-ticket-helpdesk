<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Http;

class AlertDWH extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:dwh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = new \DateTime();
        $now_date = $date->format('Y-m-d H:i:s');
        $date->modify('-3 hours');
        $get_date = $date->format('Y-m-d H:i:s');
        $error_dl = DB::select("SELECT *
                                    FROM airflow_logs
                                    WHERE start_time >= '$get_date' 
                                        AND (status = 'failed' OR status = 'pending') 
                                        AND kategori = 'Data Lake'");
        $error_dwh = DB::select("SELECT *
                                    FROM airflow_logs
                                    WHERE start_time >= '$get_date' 
                                        AND (status = 'failed' OR status = 'pending') 
                                        AND kategori = 'Data WareHouse'");
        $error_dm = DB::select("SELECT *
                                    FROM airflow_logs
                                    WHERE start_time >= '$get_date' 
                                        AND (status = 'failed' OR status = 'pending') 
                                        AND kategori = 'Data Mart'");
        $total_table_run = DB::select("SELECT COUNT( DISTINCT dag_name) as count
                                        FROM airflow_logs
                                        WHERE start_time >= '$get_date'");

        $url = \Config::get('values.WHATSAPP_API_URL');
        $user = \Config::get('values.WHATSAPP_API_USER');
        $all_user = DB::table('users')->where('notifikasi', 1)->get();
        foreach($all_user as $u){
            $token = \Config::get('values.WHATSAPP_TOKEN');
            $message = "*NOTIFIKASI DATAWAREHOUSE*

Report untuk penarikan datawarehouse:
- Start Time: $get_date
- End Time: $now_date

Berikut hasil penarikan data untuk DataWareHouse:

";
            if (count($error_dl) == 0){
                $message .= "DATA LAKE:
*Semua penarikan berhasil*

";
            } else {
                $message .= "DATA LAKE:
Terdapat ".count($error_dl)." error dalam penarikan data lake:

";
                foreach($error_dl as $key => $er){
                    $c = $key + 1;
                    $message .= $c.". DAG Name: ".$er->dag_name."
- Process Name: ".$er->process_name."
- Type: ".$er->type."
- Status: ".$er->status."
- Error Message: ".$er->error_message."

";
                }
            }
            if (count($error_dwh) == 0){
                $message .= "DATA WAREHOUSE:
*Semua penarikan berhasil*

";
            } else {
                $message .= "DATA WAREHOUSE:
Terdapat ".count($error_dwh)." error dalam penarikan data warehouse:

";
                foreach($error_dwh as $key => $er){
                    $c = $key + 1;
                    $message .= $c.". DAG Name: ".$er->dag_name."
- Process Name: ".$er->process_name."
- Type: ".$er->type."
- Status: ".$er->status."
- Error Message: ".$er->error_message."

";
                }
            }
            if (count($error_dm) == 0){
                $message .= "DATA MART:
*Semua penarikan berhasil*

";
            } else {
                $message .= "DATA MART:
Terdapat ".count($error_dm)." error dalam penarikan data mart:

";
                foreach($error_dm as $key => $er){
                    $c = $key + 1;
                    $message .= $c.". DAG Name: ".$er->dag_name."
- Process Name: ".$er->process_name."
- Type: ".$er->type."
- Status: ".$er->status."
- Error Message: ".$er->error_message."

";
                }
            }
            $message .= "TOTAL TABLE DITARIK: ".$total_table_run[0]->count;
            $nomor = $u->nomor_hp;
            $response = Http::timeout(10)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->post($url.'/'.$user.'/send_message', [
                'number' => $nomor,
                'type' => 'text',
                // 'image' => $image_path,
                'message' => $message
            ]);
        }
        // return $response;
        
        return 1;
    }
}
