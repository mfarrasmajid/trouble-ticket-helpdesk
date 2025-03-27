<?php 

namespace App\Traits;
use App\Classes\SSP;

trait SSPDWHLog {

    public function list_dwh_log()
    {
        // DB table to use
        $table = "(
            SELECT 
                DISTINCT mark, type, DATE(start_time),
                (SELECT COUNT(id) FROM airflow_logs WHERE dag_name = al.dag_name AND status = 'success' AND DATE(start_time) = DATE(al.start_time)) success,
                (SELECT COUNT(id) FROM airflow_logs WHERE dag_name = al.dag_name AND status = 'pending' AND DATE(start_time) = DATE(al.start_time)) pending,
                (SELECT COUNT(id) FROM airflow_logs WHERE dag_name = al.dag_name AND status = 'failed' AND DATE(start_time) = DATE(al.start_time)) failed,
            FROM airflow_logs al
            ORDER BY al.start_time DESC
            GROUP BY al.mark, al.type
            ) temp";

        // Table's primary key
        $primaryKey = 'id';

        $columns = array();
        $i = 0;
        $columns[] = array( 'db' => 'id', 'dt' => $i, 
                            'formatter'=> function($value, $model){
                                $array = (array)$model;
                                return $value;
                            }
                        );
        $i++;
        $columns[] = array( 'db' => 'table', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'deskripsi', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'id', 'dt' => $i, 
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
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
    }
}
