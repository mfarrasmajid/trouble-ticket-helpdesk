<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Traits\SSPAirflowLogs;
use App\Traits\SSPAirflowLogsDetail;
use App\Traits\SSPAirflowLogsDetailID;

class DWHController extends Controller
{
    use SSPAirflowLogs;
    use SSPAirflowLogsDetail;
    use SSPAirflowLogsDetailID;

    public function __construct()
    {
        $this->middleware(['session', 'ceklogin']);
    }

    public function get_list_airflow_logs($kategori) { return $this->list_airflow_logs($kategori); }
    public function get_list_airflow_logs_detail($dag_name) { return $this->list_airflow_logs_detail($dag_name); }
    public function get_list_airflow_logs_detail_id($mark) { return $this->list_airflow_logs_detail_id($mark); }
    
    public function dashboard_dwh (Request $request){
        return view('dwh.dashboard_dwh');
    }

    public function manage_airflow_logs(Request $request) {
        return view('dwh.manage_airflow_logs');
    }

    public function detail_airflow_logs(Request $request, $dag_name) {
        $data['airflow_table'] = DB::table('airflow_table as att')->leftJoin('airflow_logs as al', 'att.table_airflow', '=', 'al.dag_name')
                                                                ->where('att.table_airflow', $dag_name)
                                                                ->select('att.*', 'al.type')
                                                                ->orderBy('al.start_time', 'DESC')
                                                                ->get();
        if (count($data['airflow_table']) == 0){
            return redirect()->route('manage_airflow_logs')->with('error', 'Log tidak ditemukan!');
        }
        $data['airflow_table'] = $data['airflow_table']->first();
        $data['table_name'] = $data['airflow_table']->table_airflow;
        $data['data_type'] = $data['airflow_table']->type_table;
        $data['extract_method'] = $data['airflow_table']->type;
        return view('dwh.detail_airflow_logs', compact('data'));
    }

    public function detail_airflow_logs_id(Request $request, $mark) {
        $data['airflow_logs'] = DB::table('airflow_logs as al')->where('al.mark', $mark)
                                                                ->select('al.*')
                                                                ->get();
        if (count($data['airflow_logs']) == 0){
            return redirect()->route('manage_airflow_logs')->with('error', 'Log ID tidak ditemukan!');
        }
        $data['airflow_logs'] = $data['airflow_logs']->first();
        $data['table_name'] = $data['airflow_logs']->dag_name;
        $data['log_id'] = $data['airflow_logs']->mark;
        return view('dwh.detail_airflow_logs_id', compact('data'));
    }

    public function status_airflow(Request $request){
        $date = date('Y-m-d');
        $data['start_time'] = $date.' 00:00:00';
        $data['end_time'] = date('Y-m-d H:i:s');
        $type = ['Data Lake', 'Data WareHouse', 'Data Mart'];
        foreach($type as $t){
            $query = "SELECT 
                    DISTINCT att.table_airflow,
                    att.type_table, DATE(al.start_time) as start_time, al.dag_name, al.type,
                    COUNT(*) FILTER (WHERE al.status = 'success') AS success,
                    COUNT(*) FILTER (WHERE al.status = 'pending') AS pending,
                    COUNT(*) FILTER (WHERE al.status = 'failed') AS failed
                FROM airflow_table att
                LEFT JOIN airflow_logs al
                    ON al.dag_name = att.table_airflow
                WHERE ((DATE(al.start_time) = '$date') OR DATE(al.start_time) IS NULL) AND att.type_table = '$t'
                GROUP BY att.table_airflow, att.type_table, DATE(al.start_time), al.dag_name, al.type
                ORDER BY att.table_airflow ASC";
            $data[$t] = DB::select($query);
            $data[$t.' New'] = [];
            foreach($data[$t] as $d){
                $status = "";
                if ($d->pending > 0){
                    $status = $status."<span class='badge badge-sm badge-warning'>Pending ".$d->pending."</span>";
                }
                if (($d->pending > 0) && ($d->failed > 0)){
                    $status = $status."<br><span class='badge badge-sm badge-danger'>Failed ".$d->failed."</span>";
                } else if ($d->failed > 0){
                    $status = $status."<span class='badge badge-sm badge-danger'>Failed ".$d->failed."</span>";
                }
                if (($d->pending == 0) && ($d->failed == 0) && ($d->success > 0)){
                    $status = "<span class='badge badge-sm badge-success'>All Success</span>";
                } else if ($d->success > 0){
                    if ($d->success > ($d->failed + $d->pending)){
                        $status = "<span class='badge badge-sm badge-success'>Mostly Success</span><br>";
                    } else {
                        $status = "<span class='badge badge-sm badge-success'>Partial Success</span><br>";
                    }
                } else if ($status == ""){
                    $status = "<span class='badge badge-sm badge-secondary'>No Status</span>";
                }
                $d->status = $status;
                $data[$t.' New'][] = $d;
            }
        }
        return view('dwh.status_airflow', compact('data'));
    }
}
