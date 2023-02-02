<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Det_Post;
use App\M_Tag;
use App\M_Det_Dharmagita;
use App\M_Video;
use App\M_Audio;
use App\M_Det_Kakawin;

class KakawinController extends Controller
{
    public function listAllKakawin()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.deskripsi')
                    ->where('tb_post.id_tag', '=', '11')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_lagu[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
                'deskripsi'      => $data->deskripsi,
            );
        }

        if(isset($new_lagu)){
            return response()->json($new_lagu);
        }else {
            $new_lagu = [];
            return response()->json($new_lagu);
        }
    }

    public function listKategoriKakawin($id_kakawin)
    {
        $datas = M_Tag::where('tb_detil_post.id_root_post', $id_kakawin)
                                ->where('tb_detil_post.id_tag', '11')
                                ->where('tb_post.is_approved', 1)
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

    public function detailKakawin($id_post)
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

    public function detailBaitKakawin($id_post)
    {
        $det_pros = M_Det_Kakawin::where('sekar_agung_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'urutan'   => "Lirik ke-".$d_pros->urutan_bait,
                    'bait'     => $d_pros->bait_sekar_agung,
                    'arti'     => $d_pros->arti_sekar_agung,
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

    public function detailArtiKakawin($id_post)
    {
        $det_pros = M_Det_Kakawin::where('sekar_agung_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'urutan'   => "Arti ke-".$d_pros->urutan_bait,
                    'arti'     => $d_pros->arti_sekar_agung,
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

    public function listVideoKakawin($id_kakawin)
    {
        $datas = M_Video::where('tb_video.id_dharmagita',$id_kakawin)
                            ->select('tb_video.id_video',
                                    'tb_video.id_dharmagita',
                                    'tb_video.judul_video',
                                    'tb_video.gambar_video',
                                    'tb_video.video')
                                    ->where('tb_video.is_approved_video', 1)
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

    public function listAudioKakawin($id_post)
    {
        $datas = M_Audio::where('tb_audio.id_dharmagita',$id_post)
                            ->select('tb_audio.id_audio',
                                    'tb_audio.id_dharmagita',
                                    'tb_audio.judul_audio',
                                    'tb_audio.gambar_audio',
                                    'tb_audio.audio')
                                    ->where('tb_audio.is_approved_audio', 1)
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

    public function YadnyaKakawin($id_kakawin)
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                 ->select('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.gambar')
                 ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_post')
                ->where('tb_post.is_approved', 1)
                ->where('tb_post.id_kategori', '!=', null)
                ->where('tb_detil_post.id_tag', '=', '11')
                ->where('tb_detil_post.id_parent_post', $id_kakawin)
                ->orderBy('tb_post.id_post', 'desc')
                ->get();
                if($datas->count() > 0) {
                foreach ($datas as $data) {
                    $new_kidung[]=(object) array(
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

    public function listKategoriKakawinUser($id_kakawin, $id_user)
    {
        $datas = M_Tag::where('tb_detil_post.id_post', $id_kakawin)
                                ->where('tb_detil_post.id_tag', '11')
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

    public function createKakawin(Request $request)
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
        $datas->id_tag      = 11;
        $datas->id_post        = $request->id_kakawin;
        $datas->id_parent_post = $data->id_post;
        $datas->id_root_post = $request->id_kakawin;
    
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

    public function updateKakawin(Request $request, $id_post)
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

    public function showKakawin($id_post)
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

    public function deleteKakawin($id_post)
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
}
