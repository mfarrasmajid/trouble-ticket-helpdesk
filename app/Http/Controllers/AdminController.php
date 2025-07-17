<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\SSPManageUsers;
use App\Traits\SSPManageAirflowTable;
use DB;

class AdminController extends Controller
{
    use SSPManageUsers;
    use SSPManageAirflowTable;

    public function __construct()
    {
        $this->middleware(['session', 'ceklogin', 'cekadmin']);
    }

    public function get_list_manage_users() { return $this->list_manage_users(); }
    public function get_list_manage_airflow_table() { return $this->list_manage_airflow_table(); }


    public function dashboard_admin(Request $request) {
        return view('admin.dashboard_admin');
    }

    public function manage_users(Request $request) {
        return view('admin.manage_users');
    }

    public function detail_users(Request $request, $id = NULL){
        $data['privilege'] = DB::table('master_privilege')->select('*')->get();
        $data['mitra_om'] = DB::connection('pgsql2')->table('mart_om_troubleticketcomp')->select(DB::raw("DISTINCT(mitra_om) as mitra_om"))->get();
        if ($id != NULL){
            $data['u'] = DB::table('users')->select('*')->where('id', $id)->get();
            if (count($data['u']) > 0){
                $data['u'] = $data['u']->first();
                $data['id'] = $id;
                return view('admin.detail_users', compact('data'));
            } else {
                return view('admin.detail_users', compact('data'))->with('error', 'User ID tidak ditemukan! Mulai menambahkan user baru.');
            }
        } else {
            return view('admin.detail_users', compact('data'));
        }
    }

    public function submit_users(Request $request, $id = NULL){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $datetime = date('Y-m-d H:i:s');
        $input = $request->all();
        if (isset($input['status_active'])){
            $status_active = 1;
        } else {
            $status_active = 0;
        }
        if (isset($input['notifikasi'])){
            $notifikasi = 1;
        } else {
            $notifikasi = 0;
        }
        if (isset($input['mitra_om'])){
            $mitra_om = implode(',', $input['mitra_om']);
        } else {
            $mitra_om = '';
        }
        if ($id == NULL){
            if (trim($input['password']) == ''){
                $password = Hash::make('dwhMitratel#135');
            } else {
                $password = Hash::make($input['password']);
            }
            $update = DB::table('users')->insertGetId([
                                            'nik_tg' => $input['nik_tg'],
                                            'name' => $input['name'],
                                            'password' => $password,
                                            'privilege' => $input['privilege'],
                                            'status_active' => $status_active,
                                            'mitra_om' => $mitra_om,
                                            'notifikasi' => $notifikasi,
                                            'email' => $input['email'],
                                            'nomor_hp' => $input['nomor_hp'],
                                            'created_at' => $datetime,
                                            'created_by' => $nik_tg,
                                        ]);
            $id = $update;
            $redirect = 0;
        } else {
            $check = DB::table('users')->where('id', $id)->select('*')->get()->first();
            if (trim($input['password']) == ''){
                $password = $check->password;
            } else {
                $password = Hash::make($input['password']);
            }
            $update = DB::table('users')->where('id', $id)
                                        ->update([
                                            'nik_tg' => $input['nik_tg'],
                                            'name' => $input['name'],
                                            'password' => $password,
                                            'privilege' => $input['privilege'],
                                            'status_active' => $status_active,
                                            'mitra_om' => $mitra_om,
                                            'notifikasi' => $notifikasi,
                                            'email' => $input['email'],
                                            'nomor_hp' => $input['nomor_hp'],
                                            'updated_at' => $datetime,
                                            'updated_by' => $nik_tg,
                                        ]);
            $redirect = 1;
        }
        $activity = 'Success Update Detail User DWH Monitoring ID '.$id.', NIK TG '.$input['nik_tg'];
        $status = 'SUCCESS';
        DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        if ($redirect){
            return redirect()->route('detail_users', ['id' => $id])->with('success', 'Update user berhasil.');
        } else {
            return redirect()->route('detail_users')->with('success', 'Update user berhasil.');
        }
    }

    public function delete_users(Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $datetime = date('Y-m-d H:i:s');
        $delete = DB::table('users')->where('id', $id)->delete();
        $activity = 'Delete User DWH ID '.$id;
        $status = 'SUCCESS';
        DB::table('log')->insert([
                        'nik_tg' => $nik_tg,
                        'activity' => $activity,
                        'status' => $status,
                        'datetime' => $datetime
                    ]);
        $request->session()->flash('success', 'User DWH berhasil dihapus.');
        return 1;
    }

    // public function manage_airflow_table(Request $request) {
    //     return view('admin.manage_airflow_table');
    // }

    // public function detail_airflow_table(Request $request, $id = NULL){
    //     $data = [];
    //     if ($id != NULL){
    //         $data['u'] = DB::table('airflow_table')->select('*')->where('id', $id)->get();
    //         if (count($data['u']) > 0){
    //             $data['u'] = $data['u']->first();
    //             $data['id'] = $id;
    //             return view('admin.detail_airflow_table', compact('data'));
    //         } else {
    //             return view('admin.detail_airflow_table', compact('data'))->with('error', 'Table ID tidak ditemukan! Mulai menambahkan user baru.');
    //         }
    //     } else {
    //         return view('admin.detail_airflow_table', compact('data'));
    //     }
    // }

    // public function submit_airflow_table(Request $request, $id = NULL){
    //     $nik_tg = $request->session()->get('user')->nik_tg;
    //     $datetime = date('Y-m-d H:i:s');
    //     $input = $request->all();
    //     if ($id == NULL){
    //         $update = DB::table('airflow_table')->insertGetId([
    //                                         'table_airflow' => $input['table'],
    //                                         'deskripsi' => $input['deskripsi'],
    //                                         'type_table' => $input['type_table'],
    //                                         'created_at' => $datetime,
    //                                         'created_by' => $nik_tg,
    //                                     ]);
    //         $id = $update;
    //         $redirect = 0;
    //     } else {
    //         $update = DB::table('airflow_table')->where('id', $id)
    //                                     ->update([
    //                                         'table_airflow' => $input['table'],
    //                                         'deskripsi' => $input['deskripsi'],
    //                                         'type_table' => $input['type_table'],
    //                                         'updated_at' => $datetime,
    //                                         'updated_by' => $nik_tg,
    //                                     ]);
    //         $redirect = 1;
    //     }
    //     $activity = 'Success Update Detail Airflow Table ID '.$id.', Table '.$input['table'];
    //     $status = 'SUCCESS';
    //     DB::table('log')->insert([
    //         'nik_tg' => $nik_tg,
    //         'activity' => $activity,
    //         'status' => $status,
    //         'datetime' => $datetime
    //     ]);
    //     if ($redirect){
    //         return redirect()->route('detail_airflow_table', ['id' => $id])->with('success', 'Update table berhasil.');
    //     } else {
    //         return redirect()->route('detail_airflow_table')->with('success', 'Update table berhasil.');
    //     }
    // }

    // public function delete_airflow_table(Request $request, $id){
    //     $nik_tg = $request->session()->get('user')->nik_tg;
    //     $datetime = date('Y-m-d H:i:s');
    //     $delete = DB::table('airflow_table')->where('id', $id)->delete();
    //     $activity = 'Delete Airflow Table DWH ID '.$id;
    //     $status = 'SUCCESS';
    //     DB::table('log')->insert([
    //                     'nik_tg' => $nik_tg,
    //                     'activity' => $activity,
    //                     'status' => $status,
    //                     'datetime' => $datetime
    //                 ]);
    //     $request->session()->flash('success', 'Table DWH berhasil dihapus.');
    //     return 1;
    // }
}
