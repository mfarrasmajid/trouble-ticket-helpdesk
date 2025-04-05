<?php 

namespace App\Traits;
use App\Classes\SSP;

trait SSPAirflowLogsDetailID {

    public function list_airflow_logs_detail_id($mark)
    {
        $table = "(
            SELECT *
            FROM airflow_logs WHERE mark = '$mark'
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
        $columns[] = array( 'db' => 'mark', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'dag_name', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'type', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'kategori', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'status', 'dt' => $i, 
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
        $columns[] = array( 'db' => 'end_time', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'error_message', 'dt' => $i, 
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
