<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Tag;
use App\M_Status;
use App\M_Det_Post;
use DB;

class YadnyaController extends Controller
{
    public function listAllYadnyaAdmin($id_yadnya)
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->where('tb_post.id_kategori', '=', $id_yadnya)
                    ->where('tb_post.id_tag', null)
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_yadnya[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
            );
        }

        if(isset($new_yadnya)){
            return response()->json($new_yadnya);
        }else {
            $new_yadnya = [];
            return response()->json($new_yadnya);
        }
    }

    public function detailYadnyaAdmin($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',
                                    'tb_kategori.nama_kategori',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($kategori_post);
    }

    public function createYadnya(Request $request)
    {
        $kat = M_Kategori::where('nama_kategori', $request->kategori)->first();

        $data              = new M_Post;
        $data->nama_post   = $request->nama_post;
        $data->id_kategori = $kat->id_kategori;
        $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        $data->is_approved = 1;
        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data->gambar = $image;
        }else {
            $data->gambar = '1598346946_Atma Wedana.jpg';
        }

        if($data->save()){
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

    public function showYadnya($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);
        $kategori_post['video'] = 'https://youtu.be/'.$kategori_post->video;

        return response()->json($kategori_post);
    }

    public function updateYadnya(Request $request, $id_post)
    {
        $data              = M_Post::where('id_post',$id_post)->first();
        $data->nama_post   = $request->nama_post;
        $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data->gambar = $image;
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

    public function deleteYadnya($id_post)
    {
        $data = M_Post::where('id_post',$id_post)->first();
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

    public function listAllProsesiAwalYadnyaAdmin($id_post){
        $det_pros = M_Status::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_status', '1')
                                ->leftJoin('tb_detil_post','tb_status.id_status','=','tb_detil_post.id_status')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_status.id_status', 
                                        'tb_status.nama_status',
                                        'tb_post.nama_post', 
                                        'tb_detil_post.id_post',
                                        'tb_detil_post.id_det_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_detil_post.posisi')
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $key => $d_pros) {
                if ($det_pros->count() == 1){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'none',
                    );
                }else if($key == 0){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'first',
                    );
                }else if($key == $det_pros->count() - 1){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'last',
                    );
                }else{
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'middle',
                    );
                }
            }
        } else {
            $new_pros = [];
        }

        return response()->json($new_pros);
    }

    public function listAllProsesiAwalNotYetOnYadnya($id_post){
        $check = M_Post::where('id_tag', '3')->orderBy('id_post', 'desc')->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '1')
                                ->where('id_post', $id_post)
                                ->first();
            if($val == null){
                $new_check[] = (object) array(
                    'id_post'   => $c->id_post,
                    'nama_post' => $c->nama_post,
                    'gambar'    => $c->gambar,
                );
            }
        }

        if(isset($new_check)){
            return response()->json($new_check);
        }else {
            $new_check = [];
            return response()->json($new_check);
        }
    }

    public function addProsesiAwalToYadnya(Request $request, $id_post){
        $getLatestUrutan = M_Det_Post::select('posisi')->where('id_post', $id_post)->orderBy('posisi', 'DESC')->first();

        $data                 = new M_Det_Post;
        $data->id_post        = $id_post;
        $data->id_parent_post = $request->id_prosesi;
        $data->id_tag         = 3;
        $data->id_status      = 1;
        if($getLatestUrutan){
            $data->posisi = intval($getLatestUrutan->posisi) + 1;
        }else {
            $data->posisi = 1;
        }

        if($data->save()){
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

    public function upProsesiAwal(Request $request, $id_post){
        $data = M_Det_Post::where('id_post', $id_post)
                            ->where('id_tag', '3')
                            ->where('id_status', '1')
                            ->where('id_det_post', $request->id_prosesi)
                            ->first();
        $data_up = M_Det_Post::where('id_post', $id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '1')
                                ->where('posisi', $data->posisi - 1)
                                ->first();

        $data_up->posisi = $data->posisi;
        $data->posisi    = $data->posisi - 1;

        if($data_up->save() && $data->save()){
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

    public function downProsesiAwal(Request $request, $id_post){
        $data = M_Det_Post::where('id_post', $id_post)
                            ->where('id_tag', '3')
                            ->where('id_status', '1')
                            ->where('id_det_post', $request->id_prosesi)
                            ->first();
        $data_down = M_Det_Post::where('id_post', $id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '1')
                                ->where('posisi', $data->posisi + 1)
                                ->first();

        $data_down->posisi = $data->posisi;
        $data->posisi    = $data->posisi + 1;

        if($data_down->save() && $data->save()){
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

    public function deleteProsesiAwalFromYadnya(Request $request, $id){
        $data = M_Det_Post::where('id_det_post', $id)
                            ->where('id_tag', 3)
                            ->where('id_status', 1)
                            ->first();
        if($data->delete()){
            $i = 0;
            $datas = M_Det_Post::where('id_post', $request->yadnya_id)->orderBy('posisi', 'ASC')->get();
            foreach ($datas as $key) {
                DB::table('tb_detil_post')
                    ->where('id_det_post', $key->id)
                    ->update(['posisi' => $i+=1]);
            }
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

    public function listAllProsesiPuncakYadnyaAdmin($id_post){
        $det_pros = M_Status::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_status', '2')
                                ->leftJoin('tb_detil_post','tb_status.id_status','=','tb_detil_post.id_status')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_status.id_status', 
                                        'tb_status.nama_status',
                                        'tb_post.nama_post', 
                                        'tb_detil_post.id_post',
                                        'tb_detil_post.id_det_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_detil_post.posisi')
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $key => $d_pros) {
                if ($det_pros->count() == 1){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'none',
                    );
                }else if($key == 0){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'first',
                    );
                }else if($key == $det_pros->count() - 1){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'last',
                    );
                }else{
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'middle',
                    );
                }
            }
        } else {
            $new_pros = [];
        }

        return response()->json($new_pros);
    }

    public function listAllProsesiPuncakNotYetOnYadnya($id_post){
        $check = M_Post::where('id_tag', '3')->orderBy('id_post', 'desc')->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '2')
                                ->where('id_post', $id_post)
                                ->first();
            if($val == null){
                $new_check[] = (object) array(
                    'id_post'   => $c->id_post,
                    'nama_post' => $c->nama_post,
                    'gambar'    => $c->gambar,
                );
            }
        }

        if(isset($new_check)){
            return response()->json($new_check);
        }else {
            $new_check = [];
            return response()->json($new_check);
        }
    }

    public function addProsesiPuncakToYadnya(Request $request, $id_post){
        $getLatestUrutan = M_Det_Post::select('posisi')->where('id_post', $id_post)->orderBy('posisi', 'DESC')->first();

        $data                 = new M_Det_Post;
        $data->id_post        = $id_post;
        $data->id_parent_post = $request->id_prosesi;
        $data->id_tag         = 3;
        $data->id_status      = 2;
        if($getLatestUrutan){
            $data->posisi = intval($getLatestUrutan->posisi) + 1;
        }else {
            $data->posisi = 1;
        }

        if($data->save()){
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

    public function upProsesiPuncak(Request $request, $id_post){
        $data = M_Det_Post::where('id_post', $id_post)
                            ->where('id_tag', '3')
                            ->where('id_status', '2')
                            ->where('id_det_post', $request->id_prosesi)
                            ->first();
        $data_up = M_Det_Post::where('id_post', $id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '2')
                                ->where('posisi', $data->posisi - 1)
                                ->first();

        $data_up->posisi = $data->posisi;
        $data->posisi    = $data->posisi - 1;

        if($data_up->save() && $data->save()){
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

    public function downProsesiPuncak(Request $request, $id_post){
        $data = M_Det_Post::where('id_post', $id_post)
                            ->where('id_tag', '3')
                            ->where('id_status', '2')
                            ->where('id_det_post', $request->id_prosesi)
                            ->first();
        $data_down = M_Det_Post::where('id_post', $id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '2')
                                ->where('posisi', $data->posisi + 1)
                                ->first();

        $data_down->posisi = $data->posisi;
        $data->posisi      = $data->posisi + 1;

        if($data_down->save() && $data->save()){
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

    public function deleteProsesiPuncakFromYadnya(Request $request, $id){
        $data = M_Det_Post::where('id_det_post', $id)
                            ->where('id_tag', 3)
                            ->where('id_status', 2)
                            ->first();
        if($data->delete()){
            $i = 0;
            $datas = M_Det_Post::where('id_post', $request->yadnya_id)->orderBy('posisi', 'ASC')->get();
            foreach ($datas as $key) {
                DB::table('tb_detil_post')
                    ->where('id_det_post', $key->id)
                    ->update(['posisi' => $i+=1]);
            }
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

    public function listAllProsesiAkhirYadnyaAdmin($id_post){
        $det_pros = M_Status::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_status', '3')
                                ->leftJoin('tb_detil_post','tb_status.id_status','=','tb_detil_post.id_status')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_status.id_status', 
                                        'tb_status.nama_status',
                                        'tb_post.nama_post', 
                                        'tb_detil_post.id_post',
                                        'tb_detil_post.id_det_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_detil_post.posisi')
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $key => $d_pros) {
                if ($det_pros->count() == 1){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'none',
                    );
                }else if($key == 0){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'first',
                    );
                }else if($key == $det_pros->count() - 1){
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'last',
                    );
                }else{
                    $new_pros[] = (object) array(
                        'id'        => $d_pros->id_det_post,
                        'id_post'   => $d_pros->id_parent_post,
                        'nama_post' => $d_pros->nama_post,
                        'posisi'    => $d_pros->posisi,
                        'index'     => 'middle',
                    );
                }
            }
        } else {
            $new_pros = [];
        }

        return response()->json($new_pros);
    }

    public function listAllProsesiAkhirNotYetOnYadnya($id_post){
        $check = M_Post::where('id_tag', '3')->orderBy('id_post', 'desc')->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '3')
                                ->where('id_post', $id_post)
                                ->first();
            if($val == null){
                $new_check[] = (object) array(
                    'id_post'   => $c->id_post,
                    'nama_post' => $c->nama_post,
                    'gambar'    => $c->gambar,
                );
            }
        }

        if(isset($new_check)){
            return response()->json($new_check);
        }else {
            $new_check = [];
            return response()->json($new_check);
        }
    }

    public function addProsesiAkhirToYadnya(Request $request, $id_post){
        $getLatestUrutan = M_Det_Post::select('posisi')->where('id_post', $id_post)->orderBy('posisi', 'DESC')->first();

        $data                 = new M_Det_Post;
        $data->id_post        = $id_post;
        $data->id_parent_post = $request->id_prosesi;
        $data->id_tag         = 3;
        $data->id_status      = 3;
        if($getLatestUrutan){
            $data->posisi = intval($getLatestUrutan->posisi) + 1;
        }else {
            $data->posisi = 1;
        }

        if($data->save()){
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

    public function upProsesiAkhir(Request $request, $id_post){
        $data = M_Det_Post::where('id_post', $id_post)
                            ->where('id_tag', '3')
                            ->where('id_status', '3')
                            ->where('id_det_post', $request->id_prosesi)
                            ->first();
        $data_up = M_Det_Post::where('id_post', $id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '3')
                                ->where('posisi', $data->posisi - 1)
                                ->first();

        $data_up->posisi = $data->posisi;
        $data->posisi    = $data->posisi - 1;

        if($data_up->save() && $data->save()){
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

    public function downProsesiAkhir(Request $request, $id_post){
        $data = M_Det_Post::where('id_post', $id_post)
                            ->where('id_tag', '3')
                            ->where('id_status', '3')
                            ->where('id_det_post', $request->id_prosesi)
                            ->first();
        $data_down = M_Det_Post::where('id_post', $id_post)
                                ->where('id_tag', '3')
                                ->where('id_status', '3')
                                ->where('posisi', $data->posisi + 1)
                                ->first();

        $data_down->posisi = $data->posisi;
        $data->posisi      = $data->posisi + 1;

        if($data_down->save() && $data->save()){
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

    public function deleteProsesiAkhirFromYadnya(Request $request, $id){
        $data = M_Det_Post::where('id_det_post', $id)
                            ->where('id_tag', 3)
                            ->where('id_status', 3)
                            ->first();
        if($data->delete()){
            $i = 0;
            $datas = M_Det_Post::where('id_post', $request->yadnya_id)->orderBy('posisi', 'ASC')->get();
            foreach ($datas as $key) {
                DB::table('tb_detil_post')
                    ->where('id_det_post', $key->id)
                    ->update(['posisi' => $i+=1]);
            }
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

    public function listAllGamelanYadnyaAdmin($id_post){
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '1')
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_post.nama_post', 
                                        'tb_post.gambar',
                                        'tb_detil_post.id_det_post',
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',)
                                ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id'        => $d_pros->id_det_post,
                    'id_post'   => $d_pros->id_parent_post,
                    'nama_post' => $d_pros->nama_post,
                    'gambar'    => $d_pros->gambar,
                );
            }
        } else {
            $new_pros = [];
        }

        return response()->json($new_pros);
    }

    public function listAllGamelanNotYetOnYadnya($id_post){
        $check = M_Post::where('id_tag', '1')->orderBy('id_post', 'desc')->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '1')
                                ->where('id_post', $id_post)
                                ->first();
            if($val == null){
                $new_check[] = (object) array(
                    'id_post'   => $c->id_post,
                    'nama_post' => $c->nama_post,
                    'gambar'    => $c->gambar,
                );
            }
        }

        if(isset($new_check)){
            return response()->json($new_check);
        }else {
            $new_check = [];
            return response()->json($new_check);
        }
    }

    public function addGamelanToYadnya(Request $request, $id_post){
        $data = new M_Det_Post;
        $data->id_post        = $id_post;
        $data->id_parent_post = $request->id_gamelan;
        $data->id_tag         = 1;

        if($data->save()){
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

    public function deleteGamelanFromYadnya($id_post){
        $data = M_Det_Post::where('id_det_post', $id_post)
                            ->where('id_tag',1)
                            ->first();
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

    public function listAllTariYadnyaAdmin($id_post){
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '2')
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_post.nama_post', 
                                        'tb_post.gambar',
                                        'tb_detil_post.id_det_post',
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',)
                                ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id'        => $d_pros->id_det_post,
                    'id_post'   => $d_pros->id_parent_post,
                    'nama_post' => $d_pros->nama_post,
                    'gambar'    => $d_pros->gambar,
                );
            }
        } else {
            $new_pros = [];
        }

        return response()->json($new_pros);
    }

    public function listAllTariNotYetOnYadnya($id_post){
        $check = M_Post::where('id_tag', '2')->orderBy('id_post', 'desc')->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '2')
                                ->where('id_post', $id_post)
                                ->first();
            if($val == null){
                $new_check[] = (object) array(
                    'id_post'   => $c->id_post,
                    'nama_post' => $c->nama_post,
                    'gambar'    => $c->gambar,
                );
            }
        }

        if(isset($new_check)){
            return response()->json($new_check);
        }else {
            $new_check = [];
            return response()->json($new_check);
        }
    }

    public function addTariToYadnya(Request $request, $id_post){
        $data = new M_Det_Post;
        $data->id_post        = $id_post;
        $data->id_parent_post = $request->id_tari;
        $data->id_tag         = 2;

        if($data->save()){
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

    public function deleteTariFromYadnya($id_post){
        $data = M_Det_Post::where('id_det_post', $id_post)
                            ->where('id_tag', 2)
                            ->first();
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

    public function listAllKidungYadnyaAdmin($id_post){
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '4')
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                                ->select('tb_post.nama_post', 
                                        'tb_post.gambar',
                                        'tb_detil_post.id_det_post',
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_kategori.nama_kategori')
                                ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id'            => $d_pros->id_det_post,
                    'id_post'       => $d_pros->id_parent_post,
                    'nama_post'     => $d_pros->nama_post,
                    'gambar'        => $d_pros->gambar,
                    'nama_kategori' => $d_pros->nama_kategori,
                );
            }
        } else {
            $new_pros = [];
        }

        return response()->json($new_pros);
    }

    public function listAllKidungNotYetOnYadnya($id_post){
        $check = M_Post::where('id_tag', '4')
                ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                ->orderBy('id_post', 'desc')
                ->select('tb_post.id_post',
                        'tb_post.nama_post', 
                        'tb_post.gambar',
                        'tb_kategori.nama_kategori')
                ->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '4')
                                ->where('id_post', $id_post)
                                ->first();
            if($val == null){
                $new_check[] = (object) array(
                    'id_post'   => $c->id_post,
                    'nama_post' => $c->nama_post,
                    'gambar'    => $c->gambar,
                    'kategori'  => $c->nama_kategori,
                );
            }
        }

        if(isset($new_check)){
            return response()->json($new_check);
        }else {
            $new_check = [];
            return response()->json($new_check);
        }
    }

    public function addKidungToYadnya(Request $request, $id_post){
        $data = new M_Det_Post;
        $data->id_post        = $id_post;
        $data->id_parent_post = $request->id_kidung;
        $data->id_tag         = 4;

        if($data->save()){
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

    public function deleteKidungFromYadnya($id_post){
        $data = M_Det_Post::where('id_det_post', $id_post)
                            ->where('id_tag',4)
                            ->first();
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
