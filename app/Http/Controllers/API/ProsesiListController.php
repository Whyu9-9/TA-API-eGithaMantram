<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Tag;
use App\M_Status;
use App\M_Det_Post;

class ProsesiListController extends Controller
{
    public function listAllProsesi()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post','tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->where('tb_post.id_tag', '=', '3')->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_tabuh[]=(object) array(
                'id_post'     => $data->id_post,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
            );
        }

        return response()->json($new_tabuh);
    }

    public function detailProsesi($id_post)
    {
        $detail_post = M_Post::where('tb_post.id_post',$id_post)
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',)
                            ->first();
        $detail_post['deskripsi'] = filter_var($detail_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($detail_post);
    }

    public function detailGamelanProsesiCopyReference($id_parent_post, $id_post)
    {
        $data_det_pros = M_Det_Post::where('tb_detil_post.id_post', $id_parent_post)
                                    ->where('tb_detil_post.id_tag', '1')
                                    ->where('tb_detil_post.spesial',$id_post)
                                    ->leftJoin('tb_tag', 'tb_detil_post.id_tag', '=', 'tb_tag.id_tag')
                                    ->leftJoin('tb_post', 'tb_detil_post.id_parent_post', '=', 'tb_post.id_post')
                                    ->select('tb_detil_post.id_det_post', 
                                            'tb_post.nama_post', 
                                            'tb_post.gambar', 
                                            'tb_detil_post.id_post', 
                                            'tb_detil_post.id_parent_post', 
                                            'tb_detil_post.id_tag')
                                    ->get();
        if(count($data_det_pros) > 0){
            foreach ($data_det_pros as $dp) {
                $new_ting[] = (object) array(
                    'id_post'        => $dp->id_post,
                    'id_child_post' => $dp->id_parent_post,
                    'nama_post'      => $dp->nama_post,
                    'gambar'         => $dp->gambar,
                    'id_tag'         => $dp->id_tag,
                );
            }
        }else{
            $new_ting = [];
        }

        return response()->json($new_ting);
    }

    public function detailGamelanProsesi($id_post)
    {
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '1')
                                ->where('tb_detil_post.spesial','=',null)
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_post.nama_post', 
                                        'tb_post.gambar',
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',)
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id_post'   => $d_pros->id_parent_post,
                    'nama_post' => $d_pros->nama_post,
                    'gambar'    => $d_pros->gambar,
                );
            }

            $data = [
                'data' => $new_pros,
            ];
        } else {
            $data = [
                'data' => [],
            ];
        }


        return response()->json($data);
    }
}
