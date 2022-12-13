<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Det_Post;
use App\M_Tag;
use App\M_Det_Dharmagita;
use App\M_Video;
use App\M_Audio;
use App\M_Det_Pupuh;

class PupuhController extends Controller
{
    public function listPupuhTerbaru()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    // ->where('tb_post.is_approved', 1)
                    ->where('tb_post.id_tag', '=', '10')->orderBy('tb_post.id_post', 'desc')
                    ->limit(6)
                    ->get();
        foreach ($datas as $data) {
            $new_kidung[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'id_tag'      => $data->id_tag,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
            );
        }
        $arr = [
            "data" => $new_kidung
        ];
        return response()->json($arr);
    }

    public function listAllPupuh()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.deskripsi')
                    ->where('tb_post.id_tag', '=', '10')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_pupuh[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
                'deskripsi'      => $data->deskripsi,
            );
        }

        if(isset($new_pupuh)){
            return response()->json($new_pupuh);
        }else {
            $new_pupuh = [];
            return response()->json($new_pupuh);
        }
    }

    public function listKategoriPupuh($id_pupuh)
    {
        $datas = M_Tag::where('tb_detil_post.id_post', $id_pupuh)
                                ->where('tb_detil_post.id_tag', '10')
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_post.nama_post', 
                                        'tb_post.gambar',
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_tag.nama_tag')
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
                                foreach ($datas as $data) {
                                    $new_yadnya[]=(object) array(
                                        'id_post'     => $data->id_parent_post,
                                        'id_kategori' => $data->id_kategori,
                                        'kategori'    => $data->nama_kategori,
                                        'nama_post'   => $data->nama_post,
                                        'nama_tag'   => $data->nama_tag,
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

    public function listKategoriPupuhUser($id_pupuh, $id_user)
    {
        $datas = M_Tag::where('tb_detil_post.id_post', $id_pupuh)
                                ->where('tb_detil_post.id_tag', '10')
                                ->where('tb_post.id_user', '=', $id_user)
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_post.nama_post', 
                                        'tb_post.gambar',
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_tag.nama_tag')
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
                                foreach ($datas as $data) {
                                    $new_yadnya[]=(object) array(
                                        'id_post'     => $data->id_parent_post,
                                        'id_kategori' => $data->id_kategori,
                                        'kategori'    => $data->nama_kategori,
                                        'nama_post'   => $data->nama_post,
                                        'nama_tag'   => $data->nama_tag,
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

    public function detailPupuh($id_post)
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

    public function detailBaitPupuh($id_post)
    {
        $det_pros = M_Det_Pupuh::where('pupuh_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'urutan'   => "Lirik ke-".$d_pros->urutan_bait,
                    'bait'     => $d_pros->bait_pupuh,
                );
            }

            $data = [
                'data' => $new_pros,
            ];
        }else{
            $data = [
                'data' => [],
            ];
        }

        return response()->json($data);
    }

    public function listVideoPupuh($id_pupuh)
    {
        $datas = M_Video::where('tb_video.id_dharmagita',$id_pupuh)
                            ->select('tb_video.id_video',
                                    'tb_video.id_dharmagita',
                                    'tb_video.judul_video',
                                    'tb_video.gambar_video',
                                    'tb_video.video')
                            ->get();
                            if($datas->count() > 0) {
                            foreach ($datas as $data) {
                                $new_kidung[]=(object) array(
                                    'id_video'     => $data->id_video,
                                    'id_dharmagita' => $data->id_dharmagita,
                                    'judul_video'   => $data->judul_video,
                                    'gambar_video'  => $data->gambar_video,
                                    'video'         => $data->video,
                                );
                            }
                            $arr = [
                                "data" => $new_kidung
                            ];
                        }else {
                            $arr = [
                                'data' => [],
                            ];
                        }
                            return response()->json($arr);
    }

    public function listAudioPupuh($id_post)
    {
        $datas = M_Audio::where('tb_audio.id_dharmagita',$id_post)
                            ->select('tb_audio.id_audio',
                                    'tb_audio.id_dharmagita',
                                    'tb_audio.judul_audio',
                                    'tb_audio.gambar_audio',
                                    'tb_audio.audio')
                            ->get();
                            if($datas->count() > 0) {
                            foreach ($datas as $data) {
                                $new_kidung[]=(object) array(
                                    'id_audio'     => $data->id_audio,
                                    'id_dharmagita' => $data->id_dharmagita,
                                    'judul_audio'   => $data->judul_audio,
                                    'gambar_audio'  => $data->gambar_audio,
                                    'audio'         => $data->audio,
                                );
                            }
                            $arr = [
                                "data" => $new_kidung
                            ];
                        }else {
                            $arr = [
                                'data' => [],
                            ];
                        }
                            return response()->json($arr);
    }

    public function YadnyaPupuh($id_pupuh)
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                 ->select('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.gambar','tb_detil_post.id_det_post')
                 ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_post')
                ->where('tb_post.is_approved', 1)
                ->where('tb_post.id_kategori', '!=', null)
                ->where('tb_detil_post.id_tag', '=', '10')
                ->where('tb_detil_post.id_parent_post', $id_pupuh)
                ->orderBy('tb_post.id_post', 'desc')
                ->get();
                if($datas->count() > 0) {
                foreach ($datas as $data) {
                    $new_kidung[]=(object) array(
                        'id'        => $data->id_det_post,
                        'id_post'     => $data->id_post,
                        'id_kategori' => $data->id_kategori,
                        'kategori'    => $data->nama_kategori,
                        'nama_post'   => $data->nama_post,
                        'gambar'      => $data->gambar,
                        
                    );
                }
                $arr = [
                    "data" => $new_kidung
                ];
            }else {
                    $arr = [
                        'data' => [],
                    ];
                }
                return response()->json($arr);
    }

    public function createPupuh(Request $request)
    {
    
        $data              = new M_Post;
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = null;
        $data->id_kategori = null;
        // $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        $data->is_approved = 0;
        $data->id_user = $request->id_user;
        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data->gambar = $image;
        }else {
            $data->gambar = '1604034202_note fix.png';
        }
        $data -> save();

        $datas = new M_Det_Post;
        $datas->id_tag      = 10;
        $datas->id_post        = $request->id_pupuh;
        $datas->id_parent_post = $data->id_post;
        $datas->id_root_post = $request->id_pupuh;
    
        if($datas ->save()){
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

    public function updatePupuh(Request $request, $id_post)
    {
        $data              = M_Post::where('id_post',$id_post)->first();
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = null;
        $data->id_kategori = null;
        // $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
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

    public function showPupuh($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);
        $kategori_post['video'] = 'https://youtu.be/'.$kategori_post->video;

        return response()->json($kategori_post);
    }

    public function deletePupuh($id_post)
    {
        $datas = M_Det_Post::where('id_parent_post',$id_post)->first();
        $datas->delete();
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

    public function listBaitPupuhUser($id_post)
    {
        $det_pros = M_Det_Pupuh::where('pupuh_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        if($det_pros->count() > 0) {
        foreach ($det_pros as $d_pros) {
            $new_pros[] = (object) array(
                'id_lirik_pupuh' => $d_pros->id,
                'urutan'          => $d_pros->urutan_bait,
                'bait'            => Str::limit($d_pros->bait_pupuh, 30, '...'),
            );
        }
    }else {
        
        $new_pros = [];
        
    }
        return response()->json($new_pros);

    }

    public function addLirikPupuh(Request $request, $id_post){
        $getLatestUrutan = M_Det_Pupuh::select('urutan_bait')->where('pupuh_id', $id_post)->orderBy('urutan_bait', 'DESC')->first();

        $data = new M_Det_Pupuh;
        $data->pupuh_id   = $id_post;
        $data->bait_pupuh = $request->bait_pupuh;

        if($getLatestUrutan){
            $data->urutan_bait = intval($getLatestUrutan->urutan_bait) + 1;
        }else {
            $data->urutan_bait = 1;
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

    public function showLirikPupuh($id_det_post){
        $data = M_Det_Pupuh::where('id', $id_det_post)->first();
        return response()->json($data);
    }

    public function updateLirikPupuh(Request $request, $id_det_post){
        $data = M_Det_Pupuh::where('id', $id_det_post)->first();
        $data->bait_pupuh = $request->bait_pupuh;

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

    public function deleteLirikPupuh(Request $request, $id)
    {
        $data = M_Det_Pupuh::where('id', $id)->first();
        if($data->delete()){
            $i = 0;
            $datas = M_Det_Pupuh::where('pupuh_id', $request->pupuh_id)->orderBy('urutan_bait', 'ASC')->get();
            foreach ($datas as $key) {
                DB::table('tb_detail_pupuh')
                    ->where('id', $key->id)
                    ->update(['urutan_bait' => $i+=1]);
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

    public function showVideoPupuh($id_post){
        $data = M_Video::where('id_video', $id_post)->first();
        $data['video'] = 'https://youtu.be/'.$data->video;
        return response()->json($data);
    }

    public function addVideoToPupuh(Request $request, $id_post){
        $data = new M_Video;
        $data->id_dharmagita = $id_post;
        $data->judul_video  = $request->judul_video;
        $data->gambar_video = $request->gambar_video;
        $data->video        = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->is_approved = 0;

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

    public function updateVideoPupuh(Request $request, $id_post){
        $data = M_Video::where('id_video', $id_post)->first();
        $data->judul_video  = $request->judul_video;
        $data->gambar_video = $request->gambar_video;
        $data->video        = preg_replace("#.*youtu\.be/#", "", $request->video);

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

    public function deleteVideoFromPupuh($id_post){
        $data = M_Video::where('id_video', $id_post)
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

    public function showAudioPupuh($id_post){
        $data = M_Audio::where('id_audio', $id_post)->first();
        return response()->json($data);
    }

    public function addAudioToPupuh(Request $request, $id_post){
        $data = new M_Audio;
        $data->id_dharmagita = $id_post;
        $data->judul_audio  = $request->judul_audio;
        $data->gambar_audio = $request->gambar_audio;
        $data->audio        = $request->audio;
        $data->is_approved = 0;

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

    public function updateAudioPupuh(Request $request, $id_post){
        $data = M_Audio::where('id_audio', $id_post)->first();
        $data->judul_audio  = $request->judul_audio;
        $data->gambar_audio = $request->gambar_audio;
        $data->audio        = $request->audio;

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

    public function deleteAudioFromPupuh($id_post){
        $data = M_Audio::where('id_audio', $id_post)
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

    public function listAllYadnyaNotYetOnPupuh($id_post){
        $check = M_Post::where('tb_post.id_kategori', '!=', null)
        ->where('tb_post.id_tag', null)
                        // ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                        // ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_post')
                        // ->where('tb_post.is_approved', 1)
                        // ->where('tb_detil_post.id_tag', '=', '10')
                        // ->where('tb_detil_post.id_parent_post', $id_post)
                        ->orderBy('tb_post.id_post', 'desc')
                        ->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_post', $c->id_post)
                                ->where('id_tag', '10')
                                // ->where('tb_post.id_kategori', '!=', null)
                                ->where('id_parent_post', $id_post)
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
            $arr = [
                "data" => $new_check
            ];
            return response()->json($arr);
        }else {
            $new_check = [];
            $arr = [
                'data' => $new_check
            ];
            return response()->json($arr);
        }
    }


    public function addYadnyaToPupuh(Request $request, $id_post){
        $data = new M_Det_Post;
        $data->id_post        = $request->id_pupuh;
        $data->id_parent_post = $id_post;
        $data->id_tag         = 10;

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

    public function deleteYadnyaFromPupuh($id_post){
        $data = M_Det_Post::where('id_det_post', $id_post)
                            ->where('id_tag',10)
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
