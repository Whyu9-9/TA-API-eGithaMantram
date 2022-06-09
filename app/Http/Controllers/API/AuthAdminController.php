<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class AuthAdminController extends Controller
{
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $data = [
                'error'    => false,
                'message'  => 'Login Sukses',
                'id_admin' => $user->id_user,
                'nama'     => $user->name,
                'role'     => $user->role,
            ];
            return response()->json($data);
        } else if($user && $request->password == $user->password){
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

    
}
