@extends('pengguna/layouts.app')

@section('konten')
<link rel="stylesheet" href="{{asset('/assets/select2/select2.min.css')}}">
<style>
	.prosesi-title {
		white-space: nowrap;
        overflow: hidden;
        display: block;
        text-overflow: ellipsis;
	}
</style>
<div class="container py-5">
    <div class="row">
        <div class="col-3">
            @if ($tag_post->gambar != '')
                <img src="/gambarku/{{$tag_post->gambar}}" alt="..." class="card-img-top">
            @else
                <img src="/assets/images/placeholder.png" alt="..." class="card-img-top">
            @endif
        </div>
        <div class="col-9">
            <h1 class="mb-3">{{$tag_post->nama_post}}</h1>
            <table width="100%" class="mb-3">
                <tr>
                    <td width="100"><strong>Jenis</strong></td>
                    <td>{{$tag_post->nama_tag}}</td>
                </tr>
            </table>
            <p>{!!$tag_post->deskripsi!!}</p>
            <div class="container_youtube">
                <iframe width="640" height="360" src="https://www.youtube.com/embed/{{ $tag_post->video }}" class="video" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <hr>
</div>
<script src="{{asset('/assets/select2/select2.min.js')}}"></script>
@endsection