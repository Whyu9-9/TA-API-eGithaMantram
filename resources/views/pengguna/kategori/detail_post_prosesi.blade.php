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
@if ($tag_post->gambar != '')
<div class="hero" style="background-image: url('/gambarku/{{$tag_post->gambar}}')">
    <div class="container">
        <h1 class="mb-3">{{$tag_post->nama_post}}</h1>
    </div>
</div>
@else
<div class="hero" style="background-image: url(/assets/images/placeholder.png)">
    <div class="container">
        <h1 class="mb-3">{{$tag_post->nama_post}}</h1>
    </div>
</div>
@endif
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="clearfix">
                @if ($tag_post->gambar != '')
                    <img src="/gambarku/{{$tag_post->gambar}}" alt="..." width="240" class="mb-3 mr-3" style="float: left">
                @else
                    <img src="/assets/images/placeholder.png" alt="..." width="240" class="mb-3 mr-3" style="float: left">
                @endif
                {!!$tag_post->deskripsi!!}
            </div>
            <div class="mb-3">
                <div class="container_youtube">
                    <iframe width="640" height="360" src="https://www.youtube.com/embed/{{ $tag_post->video }}" class="video" allowfullscreen></iframe>
                </div>
            </div>
            <hr>
            <div class="row">
                @foreach ($tag_all as $tg_al)
                <div class="col-lg-6">
                    <h3>{{$tg_al->nama_tag}}</h3>
                    @if (!empty($tg_al->det_tag))
                    <div class="row" style="margin-bottom: 16px">
                        @foreach ($tg_al->det_tag as $item)
                            @if ($tg_al->id_tag == $item->id_tag)
                            <div class="col-lg-4" style="margin-top: 16px">
                                <div class="cardmix" style="background-image: url('/gambarku/{{$item->gambar}}')">
                                    <div class="cardmix-body">
                                        {{$item->nama_post}}
                                        {{-- {{$item->id_post}}
                                        {{$item->id_parent_post}} --}}
                                    </div>
                                    <a href="/tag_pengguna/detil/{{$item->id_parent_post}}/{{$item->id_tag}}" class="btn btn-primary btn-sm btn-primer btn-cardmix">Lihat</a>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-4">
            @if (count($drop_ting) != 0)
                @foreach ($drop_ting['data_det_pros'] as $d)
                        <ul class="timeline mb-5">
                            <li>
                                <a href="/kategori_pengguna/detil_kk/{{$d->id_parent_post}}/{{$d->id_post}}/{{$d->id_tag}}/{{Request::segment(3)}}">{{$d->nama_post}}</a>
                            </li>
                        </ul>
                @endforeach
            @else
                <div class="text-muted mb-5">
                    <em>Tidak ada prosesi.</em>
                </div>
            @endif
        </div>
    </div>
</div>
<script src="{{asset('/assets/select2/select2.min.js')}}"></script>


@endsection