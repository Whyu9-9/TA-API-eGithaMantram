<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\M_User;
use App\M_Kategori;
use App\M_Post;

class Admin extends Controller
{

    public function index()
    {
    	if (!Session::get('login')) {
    		return redirect('login')->with('alert','Anda harus login terlebih dahulu');
    	}
    	else{
            $dashboard = M_Post::groupBy('tb_kategori.nama_kategori')
            ->where('tb_post.id_tag',NULL)
            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
            ->selectRaw("tb_kategori.nama_kategori, count('tb_post.id_post') as id_post")
            ->get();
    		return view('admin/homepage',compact('dashboard'));
    	}
    }

    public function login()
    {
    	return view('admin/login');
    }
    public function login_auth(Request $request)
    {
    	$us_name = $request->us_name;
    	$pwd = $request->pwd;
    	//Nanti pas register admin baru silahkan pakai hashing, ini hanya redirect hashing, silahkan hapus
    	// $h_pw = Hash::make('$pwd');
    	// print_r($h_pw);
    	$data = M_User::where('name',$us_name)->first();
    	if ($data) {
    		if ($pwd==$data->password) {
    			Session::put('name',$data->name);
    			Session::put('email',$data->email);
    			Session::put('login',TRUE);
    			return redirect ('admin');
    		}
    		else{
    			return redirect('login')->with('alert','Username atau Password salah !');
    		}
    	}
    		else{
    			return redirect('login')->with('alert','Username atau Password salah !');
    		}
    }
    public function logout()
    {
        Auth::logout();
    	Session::flush();
        Session::regenerate();
    	return redirect('login')->with('alert','Terimakasih, anda sudah logout sekarang');
    }
    public function operator()
    {
        $operator = M_User::paginate(10);
        return view('admin/operator/operator', ['operator' => $operator]);
    }
    public function tambah_operator()
    {
        return view('admin/operator/form_i_operator');
    }
    public function input_operator(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:4',
            'email' => 'required|min:4|email|unique:users',
            'pwd' => 'required',
            'konfirm' => 'required|same:pwd',
        ]);
        $data = new M_User();
        $data->name = $request->nama;
        $data->email = $request->email;
        $data->password = $request->pwd;
        $data->save();
        return redirect('admin/operator');
    }
    public function edit_operator($id_user)
    {
        $admin = M_User::find($id_user);
        return view('admin/operator/form_u_operator',['admin' => $admin]);
    }
    public function update_operator($id_user, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email',
            'pwd' => 'required',
            'konfirm' => 'required|same:pwd'
        ]);

        $admin = M_User::find($id_user);
        $admin->name = $request->nama;
        $admin->email = $request->email;
        $admin->password = $request->pwd;
        $admin->save();
        return redirect('admin/operator');
    }
    public function delete_operator($id_user)
    {
        $admin = M_User::find($id_user);
        $admin->delete();
        return redirect('admin/operator');
    }
    public function cari_operator(Request $request)
    {
        $cari = $request->cari;
        $operator = M_User::where('name','LIKE',"%".$cari."%")->paginate(10);
        return view('admin/operator/operator', ['operator' => $operator]);
    }

    public function routeCache()
    {
        \Artisan::call('route:cache');
        return response()->json(['message' => 'Route Cached']);
    }
}
