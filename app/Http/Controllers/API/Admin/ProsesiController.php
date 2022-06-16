<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Tag;
use App\M_Status;
use App\M_Det_Post;

class ProsesiController extends Controller
{
    public function listAllProsesiAdmin()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->where('tb_post.id_tag', '=', '3')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_prosesi[]=(object) array(
                'id_post'     => $data->id_post,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
            );
        }

        if(isset($new_prosesi)){
            return response()->json($new_prosesi);
        }else {
            $new_prosesi = [];
            return response()->json($new_prosesi);
        }
    }

    public function detailProsesiAdmin($id_post)
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

        return response()->json($kategori_post);
    }

    public function createProsesi(Request $request)
    {
        $data              = new M_Post;
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 3;
        $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        $data->is_approved = 1;
        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data->gambar = $image;
        }else {
            $data->gambar = '1604034202_note fix.png';
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

    public function showProsesi($id_post)
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

    public function updateProsesi(Request $request, $id_post)
    {
        $data = M_Post::where('id_post',$id_post)->first();
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 3;
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

    public function deleteProsesi($id_post)
    {
        $data = M_Post::where('id_post', $id_post)->first();
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

    public function listAllGamelanProsesiAdmin($id_post){
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

    public function listAllGamelanNotYetOnProsesi($id_post){
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

    public function addGamelanToProsesi(Request $request, $id_post){
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

    public function deleteGamelanFromProsesi($id_post){
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

    public function listAllTariProsesiAdmin($id_post){
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

    public function listAllTariNotYetOnProsesi($id_post){
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

    public function addTariToProsesi(Request $request, $id_post){
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

    public function deleteTariFromProsesi($id_post){
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

    public function listAllKidungProsesiAdmin($id_post){
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

    public function listAllKidungNotYetOnProsesi($id_post){
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

    public function addKidungToProsesi(Request $request, $id_post){
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

    public function deleteKidungFromProsesi($id_post){
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

    public function listAllTabuhProsesiAdmin($id_post){
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '5')
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

    public function listAllTabuhNotYetOnProsesi($id_post){
        $check = M_Post::where('id_tag', '5')->orderBy('id_post', 'desc')->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '5')
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

    public function addTabuhToProsesi(Request $request, $id_post){
        $data = new M_Det_Post;
        $data->id_post        = $id_post;
        $data->id_parent_post = $request->id_tabuh;
        $data->id_tag         = 5;

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

    public function deleteTabuhFromProsesi($id_post){
        $data = M_Det_Post::where('id_det_post', $id_post)
                            ->where('id_tag',5)
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

    public function listAllMantramProsesiAdmin($id_post){
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '6')
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                                ->select('tb_post.nama_post', 
                                        'tb_post.gambar',
                                        'tb_detil_post.id_det_post',
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_kategori.nama_kategori',)
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

    public function listAllMantramNotYetOnProsesi($id_post){
        $check = M_Post::where('id_tag', '6')
                    ->where('is_approved', '1')
                    ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->orderBy('id_post', 'desc')
                    ->select('tb_post.id_post',
                            'tb_post.nama_post', 
                            'tb_post.gambar',
                            'tb_kategori.nama_kategori')
                    ->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '6')
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

    public function addMantramToProsesi(Request $request, $id_post){
        $data = new M_Det_Post;
        $data->id_post        = $id_post;
        $data->id_parent_post = $request->id_mantram;
        $data->id_tag         = 6;

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

    public function deleteMantramFromProsesi($id_post){
        $data = M_Det_Post::where('id_det_post', $id_post)
                            ->where('id_tag', 6)
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

    public function listAllProsesiKhususAdmin($id_prosesi, $id_yadnya){
        $det_pros = M_Det_Post::where('tb_detil_post.id_post', $id_prosesi)
                        ->where('tb_detil_post.id_tag', '3')
                        ->where('tb_detil_post.spesial',$id_yadnya)
                        ->leftJoin('tb_tag', 'tb_detil_post.id_tag', '=', 'tb_tag.id_tag')
                        ->leftJoin('tb_post', 'tb_detil_post.id_parent_post', '=', 'tb_post.id_post')
                        ->select('tb_detil_post.id_det_post', 
                                'tb_post.nama_post', 
                                'tb_post.gambar', 
                                'tb_post.id_post', 
                                'tb_detil_post.id_parent_post', 
                                'tb_detil_post.id_tag',)
                        ->get();

        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id'        => $d_pros->id_det_post,
                    'id_post'   => $d_pros->id_parent_post,
                    'nama_post' => $d_pros->nama_post,
                );
            }
        } else {
            $new_pros = [];
        }

        return response()->json($new_pros);
    }

    public function listAllProsesiKhususNotYetAdmin($id_prosesi, $id_yadnya){
        $check = M_Post::where('id_tag', '3')->orderBy('id_post', 'desc')->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_parent_post', $c->id_post)
                                ->where('id_tag', '3')
                                ->where('spesial', $id_yadnya)
                                ->where('id_post', $id_prosesi)
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

    public function addProsesiKhusus(Request $request, $id_prosesi, $id_yadnya){
        $data                 = new M_Det_Post;
        $data->id_post        = $id_prosesi;
        $data->spesial        = $id_yadnya;
        $data->id_parent_post = $request->id_prosesis;
        $data->id_tag         = 3;

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

    public function deleteProsesiKhusus($id){
        $data = M_Det_Post::where('id_det_post', $id)
                            ->where('id_tag', 3)
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
