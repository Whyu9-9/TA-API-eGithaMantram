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
use App\M_Det_LaguAnak;

class LaguAnakController extends Controller
{
    public function listAllLaguAnak()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.deskripsi')
                    ->where('tb_post.id_tag', '=', '9')
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

    public function listKategoriLaguAnak($id_lagu_anak)
    {
        $datas = M_Tag::where('tb_detil_post.id_root_post', $id_lagu_anak)
                                ->where('tb_detil_post.id_tag', '9')
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_post.nama_post', 
                                        'tb_post.gambar',
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',)
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
                                foreach ($datas as $data) {
                                    $new_yadnya[]=(object) array(
                                        'id_post'     => $data->id_parent_post,
                                        'id_kategori' => $data->id_kategori,
                                        'id_tag'      => $data->id_tag,
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

    public function detailLaguAnak($id_post)
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

    public function detailBaitLaguAnak($id_post)
    {
        $det_pros = M_Det_LaguAnak::where('lagu_anak_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'urutan'   => "Lirik ke-".$d_pros->urutan_bait,
                    'bait'     => $d_pros->bait_lagu,
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

    public function listVideoLaguAnak($id_lagu_anak)
    {
        $datas = M_Video::where('tb_video.id_dharmagita',$id_lagu_anak)
                            ->select('tb_video.id_video',
                                    'tb_video.id_dharmagita',
                                    'tb_video.judul_video',
                                    'tb_video.gambar_video',
                                    'tb_video.video')
                            ->get();
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
                            return response()->json($arr);
    }

    public function listAudioLaguAnak($id_post)
    {
        $datas = M_Audio::where('tb_audio.id_dharmagita',$id_post)
                            ->select('tb_audio.id_audio',
                                    'tb_audio.id_dharmagita',
                                    'tb_audio.judul_audio',
                                    'tb_audio.gambar_audio',
                                    'tb_audio.audio')
                            ->get();
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
                            return response()->json($arr);
    }

    public function YadnyaLaguAnak($id_lagu_anak)
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                 ->select('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.gambar')
                 ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_post')
                ->where('tb_post.is_approved', 1)
                ->where('tb_post.id_kategori', '!=', null)
                ->where('tb_detil_post.id_tag', '=', '9')
                ->where('tb_detil_post.id_parent_post', $id_lagu_anak)
                ->orderBy('tb_post.id_post', 'desc')
                ->get();
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
                return response()->json($arr);
    }

}
