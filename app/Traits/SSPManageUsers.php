<?php 

namespace App\Traits;
use App\Classes\SSP;

trait SSPManageUsers {

    public function list_manage_users()
    {
        // DB table to use
        $table = "(
            SELECT * FROM users
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
        $columns[] = array( 'db' => 'nik_tg', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'name', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'privilege', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'email', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'nomor_hp', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'mitra_om', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'notifikasi', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    if ($value){
                        return "<span class='badge badge-sm badge-primary'>Aktif</span>";
                    }
                    else {
                        return "<span class='badge badge-sm badge-secondary'>Tidak Aktif</span>";
                    }
                }
            );
        $i++;
        $columns[] = array( 'db' => 'status_active', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    if ($value){
                        return "<span class='badge badge-sm badge-primary'>Aktif</span>";
                    }
                    else {
                        return "<span class='badge badge-sm badge-secondary'>Tidak Aktif</span>";
                    }
                }
            );
        $i++;
        $columns[] = array( 'db' => 'id', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
    

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
