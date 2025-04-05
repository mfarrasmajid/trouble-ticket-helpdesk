<?php 

namespace App\Traits;
use App\Classes\SSP;
use DB;

trait SSPAirflowLogsDetail {

    public function list_airflow_logs_detail($dag_name)
    {
        $get_date_modifier = DB::table('date_modifier')->select('*')->get()->first();
        // DB table to use
        $date = new \DateTime();
        $now_date = $date->format('Y-m-d');
        $date->modify($get_date_modifier->modifier);
        $get_date = $date->format('Y-m-d');
        $table = "(SELECT type_table, type, start_time, table_airflow, mark, dag_name, success, pending, failed FROM (
            SELECT 
                DISTINCT att.table_airflow, al.mark,
                att.type_table, DATE(al.start_time) as start_time, al.dag_name, al.type,
                COUNT(*) FILTER (WHERE al.status = 'success') AS success,
                COUNT(*) FILTER (WHERE al.status = 'pending') AS pending,
                COUNT(*) FILTER (WHERE al.status = 'failed') AS failed
            FROM airflow_table att
            LEFT JOIN airflow_logs al
                ON al.dag_name = att.table_airflow
            WHERE ((DATE(al.start_time) >= '$get_date' AND DATE(al.start_time) <= '$now_date') OR DATE(al.start_time) IS NULL) AND att.table_airflow = '$dag_name'
            GROUP BY att.table_airflow, al.mark, att.type_table, DATE(al.start_time), al.dag_name, al.type
            ) t
        ) temp";

        // Table's primary key
        $primaryKey = 'mark';

        $columns = array();
        $i = 0;
        $columns[] = array( 'db' => 'mark', 'dt' => $i, 
                            'formatter'=> function($value, $model){
                                $array = (array)$model;
                                return $value;
                            }
                        );
        $i++;
        $columns[] = array( 'db' => 'mark', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'table_airflow', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'start_time', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'success', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'pending', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'failed', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'mark', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;

        // SQL server connection information
        $sql_details = array(
            'user' => \Config::get('pgsql.db_username'),
            'pass' => \Config::get('pgsql.db_password'),
            'db'   => \Config::get('pgsql.db_database'),
            'host' => \Config::get('pgsql.db_host'),
            'port' => \Config::get('pgsql.db_port'),
        );
        
        
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * If you just want to use the basic configuration for DataTables with PHP
        * server-side, there is no need to edit below this line.
        */
                
        return json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
        );
    }
}
