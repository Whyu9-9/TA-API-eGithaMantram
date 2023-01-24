<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Post;
use App\M_Det_Kidung;
use App\M_Tag;
use App\M_Det_Post;
use App\M_Det_Dharmagita;
use App\M_Video;
use App\M_Audio;


class KidungListController extends Controller
{
    public function listKidungTerbaru()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    // ->where('tb_post.is_approved', 1)
                    ->where('tb_post.id_tag', '=', '4')->orderBy('tb_post.id_post', 'desc')
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

    public function listAllKidung()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->leftJoin('tb_tag','tb_post.id_tag','=','tb_tag.id_tag')
                    ->select('tb_post.id_post','tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.deskripsi','tb_tag.nama_tag')
                    // ->where('tb_post.is_approved', 1)
                    ->where('tb_post.id_tag', '=', '4')->orderBy('tb_post.id_post', 'desc')
                    ->get();

        if(count($datas) > 0){
            foreach ($datas as $data) {
                $new_kidung[]=(object) array(
                    'id_post'     => $data->id_post,
                    'id_kategori' => $data->id_kategori,
                    'kategori'    => $data->nama_kategori,
                    'nama_post'   => $data->nama_post,
                    'nama_tag'   => $data->nama_tag,
                    'gambar'      => $data->gambar,
                    'deskripsi'      => $data->deskripsi,
                );
            }
        }else{
            $new_kidung = [];
        }

        return response()->json($new_kidung);
    }

    public function detailKidung($id_post)
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

    public function detailBaitKidung($id_post)
    {
        $det_pros = M_Det_Kidung::where('kidung_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'urutan'   => "Lirik ke-".$d_pros->urutan_bait,
                    'bait'     => $d_pros->bait_kidung,
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

    public function listVideoKidung($id_kidung)
    {
        $datas = M_Video::where('tb_video.id_dharmagita',$id_kidung)
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

    public function listAudioKidung($id_post)
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

    public function YadnyaKidung($id_kidung)
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                 ->select('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.gambar')
                 ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_post')
                ->where('tb_post.is_approved', 1)
                ->where('tb_post.id_kategori', '!=', null)
                ->where('tb_detil_post.id_tag', '=', '4')
                ->where('tb_detil_post.id_parent_post', $id_kidung)
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

    public function listKategoriKidungUser($id_user)
    {
        $datas =  M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                        ->leftJoin('tb_tag','tb_post.id_tag','=','tb_tag.id_tag')
                        ->select('tb_post.id_post','tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.deskripsi','tb_tag.nama_tag')
                        // ->where('tb_post.is_approved', 1)
                        ->where('tb_post.id_user', '=', $id_user)
                        ->where('tb_post.id_tag', '=', '4')->orderBy('tb_post.id_post', 'desc')
                        ->get();
                                foreach ($datas as $data) {
                                    $new_yadnya[]=(object) array(
                                        'id_post'     => $data->id_post,
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

    public function createKidung(Request $request)
    {
        $kat = M_Kategori::where('nama_kategori',$request->kategori)->first();

        $data              = new M_Post;
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 4;
        $data->id_kategori = $kat->id_kategori;
        // $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        $data->is_approved = 1;
        $data->id_user = $request->id_user;
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
}
