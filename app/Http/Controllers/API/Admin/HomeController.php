<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Det_Post;
use App\M_Tag;

class HomeController extends Controller
{
    public function listYadnyaMaster()
    {
        $data = M_Kategori::get();

        foreach($data as $d){
            $jumlah = M_Post::where('id_kategori', $d->id_kategori)
                            ->where('tb_post.id_tag', '=', null)
                            ->count();
            $all_yadnya[]=(object) array(
                'id_kategori'   => $d->id_kategori,
                'nama_kategori' => $d->nama_kategori,
                'jumlah'        => $jumlah,
            );
        }

        return response()->json($all_yadnya);
    }

    public function listDharmagitaMaster()
    {
        $data = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                ->select('tb_post.id_post', 'tb_post.nama_post')
                ->where('tb_post.id_tag', '=', '8')
                ->orderBy('tb_post.id_post', 'desc')
                ->get();

        foreach($data as $d){
            if( $d->nama_post == 'Sekar Alit'){
                $jumlah = M_Post::where('id_tag', 10)
                ->count();
            }else if($d->nama_post == 'Sekar Madya'){
                $jumlah = M_Post::where('id_tag', 4)
                ->count();
            }else if($d->nama_post == 'Sekar Agung'){
                $jumlah = M_Post::where('id_tag', 11)
                ->count();
            }else if($d->nama_post == 'Sekar Rare'){
                $jumlah = M_Post::where('id_tag', 9)
                ->count();
            }
            $all_yadnya[]=(object) array(
                'id_post'   => $d->id_post,
                'nama_post' => $d->nama_post,
                'jumlah'        => $jumlah,
            );
        }

        return response()->json($all_yadnya);
    }


    public function selectedHomeYadnya($nama_yadnya){
        $data = M_post::where('tb_post.id_tag', null)
                    ->where('tb_kategori.nama_kategori', $nama_yadnya)
                    ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        if(count($data) > 0){
            foreach ($data as $d) {
                $new_yadnya[]=(object) array(
                    'id_post'     => $d->id_post,
                    'id_kategori' => $d->id_kategori,
                    'kategori'    => $d->nama_kategori,
                    'nama_post'   => $d->nama_post,
                    'gambar'      => $d->gambar,
                );
            }
        }else{
            $new_yadnya = [];
        }

        return response()->json($new_yadnya);
    }

    public function selectedHomeDharmagita($id_post)
    {
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '8')
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
