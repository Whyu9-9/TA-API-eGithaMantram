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


class DharmagitaController extends Controller
{
    public function listAllDharmagita()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.deskripsi')
                    ->where('tb_post.id_tag', '=', '8')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_dharmagita[]=(object) array(
                'id_post'     => $data->id_post,
                'nama_post'   => $data->nama_post,
                'deskripsi'   => $data->deskripsi,
                'gambar'      => $data->gambar,
            );
        }

        if(isset($new_dharmagita)){
            return response()->json($new_dharmagita);
        }else {
            $new_dharmagita = [];
            return response()->json($new_dharmagita);
        }
    }

    public function detailListDharmagita($id_post)
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

    public function detailDharmagita($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->leftJoin('tb_detail_dharmagita','tb_post.id_post','=','tb_detail_dharmagita.dharmagita_id')
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

    public function detailBaitDharmagita($id_post)
    {
        $det_pros = M_Det_Dharmagita::where('dharmagita_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'urutan'   => "Lirik ke-".$d_pros->urutan_bait,
                    'bait'     => $d_pros->bait_dharmagita,
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

    public function listVideo($id_post)
    {
        $det_pros = M_Video::where('tb_video.id_dharmagita',$id_post)
                            ->select('tb_video.id_video',
                                    'tb_video.id_dharmagita',
                                    'tb_video.video')
                            ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id_video'   => $d_pros->id_video,
                    'id_dharmagita' => $d_pros->id_dharmagita,
                    'video'    => $d_pros->video,
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
        return response()->json($det_pros);
    }

    public function listDharmagitaTerbaru()
    {
        $datas = M_Post::where('tb_post.id_tag', '=', '9')
                    ->orWhere('tb_post.id_tag', '=', '4')
                    ->orWhere('tb_post.id_tag', '=', '10')
                    ->orWhere('tb_post.id_tag', '=', '11')
                    ->where('tb_post.is_approved', 1)
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.nama_post', 'tb_post.deskripsi','tb_tag.nama_tag')
                    ->leftJoin('tb_tag','tb_post.id_tag','=','tb_tag.id_tag')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->limit(6)
                    ->get();
        foreach ($datas as $data) {
            $new_gita[]=(object) array(
                'id_post'     => $data->id_post,
                'id_tag'     => $data->id_tag,
                'nama_post'   => $data->nama_post,
                'nama_tag'   => $data->nama_tag,
                'gambar'      => $data->gambar,
            );
        }
        $arr = [
            "data" => $new_gita
        ];
        return response()->json($arr);
    }

    public function listAudio($id_post)
    {
        $det_pros = M_Audio::where('tb_audio.id_dharmagita',$id_post)
                            ->select('tb_audio.id_audio',
                                    'tb_audio.id_dharmagita',
                                    'tb_audio.audio')
                            ->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id_audio'   => $d_pros->id_audio,
                    'id_audio' => $d_pros->id_audio,
                    'audio'    => $d_pros->audio,
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
        return response()->json($det_pros);
    }
    
    public function listAllGita()
    {   
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_parent_post')
                    ->leftJoin('tb_tag','tb_detil_post.id_tag','=','tb_tag.id_tag')
                    ->leftJoin('tb_detail_kidung','tb_post.id_post','=','tb_detail_kidung.kidung_id')
                    ->leftJoin('tb_detail_pupuh','tb_post.id_post','=','tb_detail_pupuh.pupuh_id')
                    ->leftJoin('tb_detail_sekar_agung','tb_post.id_post','=','tb_detail_sekar_agung.sekar_agung_id')
                    ->leftJoin('tb_detail_lagu_anak','tb_post.id_post','=','tb_detail_lagu_anak.lagu_anak_id')
                    ->select ('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 
                    'tb_post.nama_post', 'tb_post.gambar', 
                    'tb_detil_post.id_tag','tb_tag.nama_tag', 'tb_detail_kidung.bait_kidung', 
                    'tb_detail_pupuh.bait_pupuh', 'tb_detail_sekar_agung.bait_sekar_agung',
                    'tb_detail_lagu_anak.bait_lagu',)
                    ->where('tb_post.is_approved', 1)
                    ->where('tb_detil_post.id_tag', '=', '9')
                    ->orWhere('tb_detil_post.id_tag', '=', '4')
                    ->orWhere('tb_detil_post.id_tag', '=', '10')
                    ->orWhere('tb_detil_post.id_tag', '=', '11')
                    ->distinct()
                    // ->groupBy('tb_post.nama_post')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();
    

        foreach ($datas as $data) {
            if($data->id_tag == 4){
                if(isset($data->bait_kidung)){
                    $bait = $data->bait_kidung;
                }else{
                    $bait = "";
                }
            }else if($data->id_tag == 9){
                if(isset($data->bait_lagu)){
                    $bait = $data->bait_lagu;
                }else{
                    $bait = "";
                }
            }else if($data->id_tag == 10){
                if(isset($data->bait_pupuh)){
                    $bait = $data->bait_pupuh;
                }else{
                    $bait = "";
                }
            }else if($data->id_tag == 11){
                if(isset($data->bait_sekar_agung)){
                    $bait = $data->bait_sekar_agung;
                }else{
                    $bait = "";
                }
            }

            $yadnya[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'id_tag'      => $data->id_tag,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'nama_tag'   => $data->nama_tag,
                'gambar'      => $data->gambar,
                'bait' => $bait,
            );
        }

        return response()->json($yadnya);
        if(isset($yadnya)){
            return response()->json($yadnya);
        }else {
            $yadnya = [];
            return response()->json($yadnya);
        }
    }

    public function listNotApprovedDharmagita()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_parent_post')
                ->leftJoin('tb_tag','tb_detil_post.id_tag','=','tb_tag.id_tag')
                ->select('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.gambar', 'tb_detil_post.id_tag','tb_tag.nama_tag')
                ->where('tb_post.is_approved', 0)
                // ->where('tb_detil_post.id_tag', '=', '9')
                // ->orWhere('tb_detil_post.id_tag', '=', '4')
                // ->orWhere('tb_detil_post.id_tag', '=', '10')
                // ->orWhere('tb_detil_post.id_tag', '=', '11')
                ->orderBy('tb_post.id_post', 'desc')
                ->get();

        foreach ($datas as $data) {
            $new_mantram[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'id_tag'      => $data->id_tag,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'nama_tag'   => $data->nama_tag,
                'gambar'      => $data->gambar,
            );
        }

        if(isset($new_mantram)){
            return response()->json($new_mantram);
        }else {
            $new_mantram = [];
            return response()->json($new_mantram);
        }
    }

    public function listNotApprovedVideoDharmagita()
    {
        $datas = M_Video::leftJoin('tb_post','tb_video.id_dharmagita','=','tb_post.id_post')
                ->leftJoin('tb_tag','tb_post.id_tag','=','tb_tag.id_tag')
                ->select('tb_video.id_video', 'tb_video.id_dharmagita' , 'tb_video.judul_video', 'tb_video.gambar_video', 'tb_video.video', 'tb_video.is_approved_video','tb_post.nama_post','tb_post.id_tag','tb_tag.nama_tag', 'tb_post.is_approved')
                ->where('tb_video.is_approved_video', 0)
                ->get();

        foreach ($datas as $data) {
            $new_mantram[]=(object) array(
                'id_video'     => $data->id_video,
                'id_dharmagita' => $data->id_dharmagita,
                'id_tag' => $data->id_tag,
                'judul_video'      => $data->judul_video,
                'gambar_video'    => $data->gambar_video,
                'is_approved_video'   => $data->is_approved_video,
                'nama_tag'   => $data->nama_tag,
                'nama_post'      => $data->nama_post,
                'is_approved_post'      => $data->is_approved,
            );
        }

        if(isset($new_mantram)){
            return response()->json($new_mantram);
        }else {
            $new_mantram = [];
            return response()->json($new_mantram);
        }
    }

    public function listNotApprovedAudioDharmagita()
    {
        $datas = M_Audio::leftJoin('tb_post','tb_audio.id_dharmagita','=','tb_post.id_post')
                ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_post')
                ->leftJoin('tb_tag','tb_detil_post.id_tag','=','tb_tag.id_tag')
                ->select('tb_audio.id_audio', 'tb_audio.id_dharmagita' , 'tb_audio.judul_audio', 'tb_audio.gambar_audio', 'tb_audio.audio', 'tb_audio.is_approved_audio','tb_post.nama_post','tb_detil_post.id_tag','tb_tag.nama_tag', 'tb_post.is_approved')
                ->where('tb_audio.is_approved_audio', 0)
                ->get();

        foreach ($datas as $data) {
            $new_mantram[]=(object) array(
                'id_audio'     => $data->id_audio,
                'id_dharmagita' => $data->id_dharmagita,
                'id_tag' => $data->id_tag,
                'judul_audio'      => $data->judul_audio,
                'gambar_audio'    => $data->gambar_audio,
                'is_approved_audio'   => $data->is_approved_audio,
                'nama_tag'   => $data->nama_tag,
                'nama_post'      => $data->nama_post,
                'is_approved_post'      => $data->is_approved,
            );
        }

        if(isset($new_mantram)){
            return response()->json($new_mantram);
        }else {
            $new_mantram = [];
            return response()->json($new_mantram);
        }
    }

    // public function detailDharmagitaNeedApprovalAdmin($id_post)
    // {
    //     $kategori_post = M_Post::where('tb_post.id_post', $id_post)
    //                         ->where('tb_post.is_approved', '!=' ,1)
    //                         ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
    //                         ->leftJoin('tb_detail_mantram','tb_post.id_post','=','tb_detail_mantram.mantram_id')
    //                         ->select('tb_post.id_post',
    //                                 'tb_post.nama_post',
    //                                 'tb_detail_mantram.jenis_mantram',
    //                                 'tb_detail_mantram.bait_mantra',
    //                                 'tb_detail_mantram.arti_mantra',
    //                                 'tb_post.video',
    //                                 'tb_post.gambar',
    //                                 'tb_post.deskripsi',
    //                                 'tb_post.approval_notes',
    //                                 'tb_kategori.nama_kategori',)
    //                         ->first();
    //     $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);

    //     return response()->json($kategori_post);
    // }

    public function approveDharmagita(Request $request, $id_post)
    {
        $data = M_Post::where('id_post', $id_post)->first();

        if ($request->stats == 'yes'){
            $data->is_approved = 1;
        }else{
            $data->is_approved = 2;
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

    public function approveVideoDharmagita(Request $request, $id_video)
    {
        $data = M_Video::where('id_video', $id_video)->first();

        if ($request->stats == 'yes'){
            $data->is_approved_video = 1;
        }else{
            $data->is_approved_video = 2;
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

    public function approveAudioDharmagita(Request $request, $id_audio)
    {
        $data = M_Audio::where('id_audio', $id_audio)->first();

        if ($request->stats == 'yes'){
            $data->is_approved_audio = 1;
        }else{
            $data->is_approved_audio = 2;
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

    public function listNoApprovalVideo()
    {
        $data = M_Video::where('tb_video.is_approved_video', 0)
                ->get();

       
            $jumlah = M_Video::where('tb_video.is_approved_video', '=', '0')
                            ->count();
            $all_yadnya =(object) array(
                // 'id_post'   => $jumlah->id_post,
                // 'nama_post' => $data->nama_post,
                'jumlah'        => $jumlah,
            );
       

        return response()->json($all_yadnya);
    }

    public function listNoApprovalAudio()
    {
        $data = M_Audio::where('tb_audio.is_approved_audio', 0)
                ->get();

       
            $jumlah = M_Audio::where('tb_audio.is_approved_audio', '=', '0')
                            ->count();
            $all_yadnya =(object) array(
                // 'id_post'   => $jumlah->id_post,
                // 'nama_post' => $data->nama_post,
                'jumlah'        => $jumlah,
            );
       

        return response()->json($all_yadnya);
    }

    public function detailVideoDharmagita($id_video)
    {
        $kategori_post = M_Video::where('tb_video.id_video',$id_video)
                            ->leftJoin('tb_post','tb_video.id_dharmagita','=','tb_post.id_post')
                            // ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detail_dharmagita.dharmagita_id')
                            ->select('tb_video.id_video', 
                            'tb_video.id_dharmagita' , 
                            'tb_video.judul_video', 
                            'tb_video.gambar_video', 
                            'tb_video.video', 
                            'tb_video.is_approved_video',
                            'tb_post.nama_post',)
                            ->first();
        // $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($kategori_post);
    }

    public function detailAudioDharmagita($id_audio)
    {
        $kategori_post = M_Audio::where('tb_audio.id_audio',$id_audio)
                            ->leftJoin('tb_post','tb_audio.id_dharmagita','=','tb_post.id_post')
                            // ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detail_dharmagita.dharmagita_id')
                            ->select('tb_audio.id_audio', 
                            'tb_audio.id_dharmagita' , 
                            'tb_audio.judul_audio', 
                            'tb_audio.gambar_audio', 
                            'tb_audio.audio', 
                            'tb_audio.is_approved_audio',
                            'tb_post.nama_post',)
                            ->first();
        // $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($kategori_post);
    }
}
