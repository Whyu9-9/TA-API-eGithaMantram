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

class KakawinController extends Controller
{
    public function listAllKakawin()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->leftJoin('tb_detail_sekar_agung','tb_post.id_post','=','tb_detail_sekar_agung.sekar_agung_id')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.deskripsi', 'tb_detail_sekar_agung.jenis_sekar_agung')
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
                'jenis_sekar_agung' => $data->jenis_sekar_agung,
            );
        }

        if(isset($new_lagu)){
            return response()->json($new_lagu);
        }else {
            $new_lagu = [];
            return response()->json($new_lagu);
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
}
