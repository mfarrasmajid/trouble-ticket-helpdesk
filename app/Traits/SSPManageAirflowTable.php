<?php 

namespace App\Traits;
use App\Classes\SSP;

trait SSPManageAirflowTable {

    public function list_manage_airflow_table()
    {
        // DB table to use
        $table = "(
            SELECT * FROM airflow_table
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
        $columns[] = array( 'db' => 'table_airflow', 'dt' => $i, 
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
