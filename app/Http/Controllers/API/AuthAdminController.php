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

    
}
