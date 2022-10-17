<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Post;
use App\M_Det_Kidung;
use App\M_Tag;

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
                    ->select('tb_post.id_post','tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.deskripsi')
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
}
