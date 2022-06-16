<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Post;
use App\M_Det_Mantram;

class MantramListController extends Controller
{
    public function listMantramTerbaru()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->where('tb_post.is_approved', 1)
                    ->where('tb_post.id_tag', '=', '6')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->limit(6)
                    ->get();
        foreach ($datas as $data) {
            $new_mantram[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'id_tag'      => $data->id_tag,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
            );
        }
        $arr = [
            "data" => $new_mantram
        ];
        return response()->json($arr);
    }

    public function listAllMantram()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' , 'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->where('tb_post.is_approved', 1)
                    ->where('tb_post.id_tag', '=', '6')->orderBy('tb_post.id_post', 'desc')
                    ->get();

        if(count($datas) > 0){
            foreach ($datas as $data) {
                $new_mantram[]=(object) array(
                    'id_post'     => $data->id_post,
                    'id_kategori' => $data->id_kategori,
                    'kategori'    => $data->nama_kategori,
                    'nama_post'   => $data->nama_post,
                    'gambar'      => $data->gambar,
                );
            }
        }else{
            $new_mantram = [];
        }

        return response()->json($new_mantram);
    }

    public function detailMantram($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->leftJoin('tb_detail_mantram','tb_post.id_post','=','tb_detail_mantram.mantram_id')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_detail_mantram.jenis_mantram',
                                    'tb_detail_mantram.bait_mantra',
                                    'tb_detail_mantram.arti_mantra',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',
                                    'tb_kategori.nama_kategori',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($kategori_post);
    }
}
