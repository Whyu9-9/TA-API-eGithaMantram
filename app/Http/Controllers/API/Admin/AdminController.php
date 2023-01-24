<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_User;
use Hash;

class AdminController extends Controller
{
    public function index(){
        $data = M_User::select('id_user','name','email')
        ->where('role', '!=', 3)
        ->get();

        return response()->json($data);
    }

    public function listUser(){
        $data = M_User::select('id_user','name','email')
        ->where('role', '=', 3)
        ->get();

        return response()->json($data);
    }

    public function createAdmin(Request $request){
        $data = new M_User;
        $data->name     = $request->name;
        $data->email    = $request->email;
        $data->password = Hash::make($request->password);
        $data->role     = 2;
        if($data->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil ditambahkan'
            ]);
        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal ditambahkan'
        ]);
        }

        return response()->json($data);
    }

    public function getDetailAdmin($id_user){
        $data = M_User::where('id_user',$id_user)
                    ->select('id_user','name','email', 'role')->first();

        return response()->json($data);
    }



    public function editAdmin(Request $request, $id_user){
        $data           = M_User::where('id_user',$id_user)->first();
        $data->name     = $request->name;
        $data->email    = $request->email;
        if($request->password != null){
            $data->password = Hash::make($request->password);
        }
        if($data->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diubah'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal diubah'
            ]);
        }
    }

    public function deleteAdmin($id_user){
        $data = M_User::where('id_user',$id_user)->first();
        if($data->mobile_is_logged == 1){
            return response()->json([
                'status'  => 401,
                'message' => 'Data gagal dihapus, data ini masih terhubung di mobile!'
            ]);
        }
        if($data->delete()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal dihapus'
            ]);
        }
    }
}