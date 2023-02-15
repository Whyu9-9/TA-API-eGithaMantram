<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_User;
use Hash;

class AuthAdminController extends Controller
{
    public function login(Request $request){
        $user = M_User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $user->mobile_is_logged = 1;
            $user->save();
            $data = [
                'error'    => false,
                'message'  => 'Login Sukses',
                'id_admin' => $user->id_user,
                'nama'     => $user->name,
                'role'     => $user->role,
                'mobile_is_logged' => $user->mobile_is_logged,
            ];
            return response()->json($data);
        } else if($user && $request->password == $user->password){
            $user->mobile_is_logged = 1;
            $user->save();
            $data = [
                'error'    => false,
                'message'  => 'Login Sukses',
                'id_admin' => $user->id_user,
                'nama'     => $user->name,
                'role'     => $user->role,
                'mobile_is_logged' => $user->mobile_is_logged,
            ];
            return response()->json($data);
        }else {
            $data = [
                'error'    => true,
                'message'  => 'Login Gagal',
            ];
            return response()->json($data);
        }
    }

    public function logout(Request $request){
        $user = M_User::where('id_user', $request->id_admin)->first();
        if ($user) {
            $user->mobile_is_logged = 0;
            $user->save();
            $data = [
                'error'    => false,
                'message'  => 'Logout Sukses',
            ];
            return response()->json($data);
        } else {
            $data = [
                'error'    => true,
                'message'  => 'Logout Gagal',
            ];
            return response()->json($data);
        }
    }

    public function register (Request $request){
        $data              = new M_User;
        $data->email       = $request->email;
        $data->password       =bcrypt($request->password);
        $data->name       = $request->name;
        $data->role       = 3;
        $data->is_approved  = 1;
        if($data ->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil ditambahkan'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal ditambahkan'
            ]);
        }
    }

    public function registerAhli (Request $request){
        $data              = new M_User;
        $data->email       = $request->email;
        $data->password       =bcrypt($request->password);
        $data->name       = $request->name;
        $data->role       = 2;
        $data->is_approved  = 0;
        // $fileAhli = time().'.pdf';
        // file_put_contents('fileAhli/'.$fileAhli,base64_decode($request->file));
        $data->file  = $request->file;
        if($data ->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil ditambahkan'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal ditambahkan'
            ]);
        }
    }

    
}
