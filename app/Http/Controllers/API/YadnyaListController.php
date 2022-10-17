<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Tag;
use App\M_Status;
use App\M_Det_Post;

class YadnyaListController extends Controller
{
    public function listYadnyaMaster()
    {
        $data = M_Kategori::get();
        return response()->json($data);
    }

    public function selectedCardYadnya($nama_yadnya){
        $data = M_post::where('tb_post.id_tag', null)
                    ->where('tb_kategori.nama_kategori', $nama_yadnya)
                    // ->where('tb_post.is_approved', 1)
                    ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        if(count($data) > 0){
            foreach ($data as $d) {
                $selected_yadnya[]=(object) array(
                    'id_post'     => $d->id_post,
                    'id_kategori' => $d->id_kategori,
                    'kategori'    => $d->nama_kategori,
                    'nama_post'   => $d->nama_post,
                    'gambar'      => $d->gambar,
                );
            }
        }else{
            $selected_yadnya = [];
        }

        return response()->json($selected_yadnya);
    }

    public function listYadnyaTerbaru()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.gambar')
                    ->where('tb_post.is_approved', 1)
                    ->where('tb_post.id_kategori', '!=', null)
                    ->where('tb_post.id_tag', '=', null)
                    ->orderBy('tb_post.id_post', 'desc')
                    ->limit(6)
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
        $arr = [
            "data" => $new_yadnya
        ];
        return response()->json($arr);
    }

    public function listAllYadnya()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.gambar')
                    ->where('tb_post.is_approved', 1)
                    ->where('tb_post.id_kategori', '!=', null)
                    ->where('tb_post.id_tag', '=', null)
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();
        foreach ($datas as $data) {
            $yadnya[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
            );
        }

        return response()->json($yadnya);
    }

    public function detailYadnya($id_post)
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

    public function detailAwal($id_post)
    {
        $det_pros = M_Status::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_status', '1')
                                ->leftJoin('tb_detil_post','tb_status.id_status','=','tb_detil_post.id_status')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_status.id_status', 
                                        'tb_status.nama_status', 
                                        'tb_post.nama_post', 
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_detil_post.posisi')
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
        if(count($det_pros) > 0){
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id_post'   => $d_pros->id_parent_post,
                    'nama_post' => $d_pros->nama_post,
                    'posisi'    => $d_pros->posisi,
                );
            }
        }else{
            $new_pros = [];
        }

        $data = [
            'data' => $new_pros,
        ];

        return response()->json($data);
    }

    public function detailPuncak($id_post)
    {
        $det_pros = M_Status::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_status', '2')
                                ->leftJoin('tb_detil_post','tb_status.id_status','=','tb_detil_post.id_status')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_status.id_status', 
                                        'tb_status.nama_status', 
                                        'tb_post.nama_post', 
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_detil_post.posisi')
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
        if(count($det_pros) > 0){
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id_post'   => $d_pros->id_parent_post,
                    'nama_post' => $d_pros->nama_post,
                    'posisi'    => $d_pros->posisi,
                );
            }
        }else{
            $new_pros = [];
        }

        $data = [
            'data' => $new_pros,
        ];

        return response()->json($data);
    }

    public function detailAkhir($id_post)
    {
        $det_pros = M_Status::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_status', '3')
                                ->leftJoin('tb_detil_post','tb_status.id_status','=','tb_detil_post.id_status')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_status.id_status', 
                                        'tb_status.nama_status', 
                                        'tb_post.nama_post', 
                                        'tb_detil_post.id_post', 
                                        'tb_detil_post.id_parent_post', 
                                        'tb_detil_post.id_tag',
                                        'tb_detil_post.posisi')
                                ->orderBy('tb_detil_post.posisi', 'ASC')
                                ->get();
        if(count($det_pros) > 0){
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id_post'   => $d_pros->id_parent_post,
                    'nama_post' => $d_pros->nama_post,
                    'posisi'    => $d_pros->posisi,
                );
            }
        }else{
            $new_pros = [];
        }

        $data = [
            'data' => $new_pros,
        ];

        return response()->json($data);
    }

    public function detailGamelan($id_post)
    {
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '1')
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

    public function detailTari($id_post)
    {
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '2')
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_post.nama_post', 
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

    public function detailKidung($id_post)
    {
        $det_pros = M_Tag::where('tb_detil_post.id_post', $id_post)
                                ->where('tb_detil_post.id_tag', '4')
                                ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
                                ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
                                ->select('tb_post.nama_post', 
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

    public function setProsesiPositionUp($id_post, $id_pros){

    }

}
