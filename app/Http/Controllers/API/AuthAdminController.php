<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class AuthAdminController extends Controller
{
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        if ($user && $user->password == $request->password) {
            $data = [
                'error'    => false,
                'message'  => 'Login Sukses',
                'id_admin' => $user->id_user,
                'nama'     => $user->name,
            ];
            return response()->json($data);
        } else {
            $data = [
                'error'    => true,
                'message'  => 'Login Gagal',
            ];
            return response()->json($data);
        }
    }

    
}
