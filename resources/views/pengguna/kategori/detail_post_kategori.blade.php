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
@if ($kategori_post->gambar != '')
<div class="hero" style="background-image: url('/gambarku/{{$kategori_post->gambar}}')">
    <div class="container">
        <h1 class="mb-3">{{$kategori_post->nama_post}}</h1>
    </div>
</div>
@else
<div class="hero" style="background-image: url(/assets/images/placeholder.png)">
    <div class="container">
        <h1 class="mb-3">{{$kategori_post->nama_post}}</h1>
    </div>
</div>
@endif
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="clearfix">
                @if ($kategori_post->gambar != '')
                    <img src="/gambarku/{{$kategori_post->gambar}}" alt="..." width="240" class="mb-3 mr-3" style="float: left">
                @else
                    <img src="/assets/images/placeholder.png" alt="..." width="240" class="mb-3 mr-3" style="float: left">
                @endif
                {!!$kategori_post->deskripsi!!}
            </div>
            <div class="mb-3">
                <div class="container_youtube">
                    <iframe width="640" height="360" src="https://www.youtube.com/embed/{{ $kategori_post->video }}" class="video" allowfullscreen></iframe>
                </div>
            </div>
            <hr>
            <div class="row">
                @foreach ($kategori_all as $kt_al)
                <div class="col-lg-6">
                    <h3>{{$kt_al->nama_tag}}</h3>
                    @if (!empty($kt_al->det_kategori))
                    <div class="row" style="margin-bottom: 16px">
                        @foreach ($kt_al->det_kategori as $item)
                            @if ($kt_al->id_tag == $item->id_tag)
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
            <!-- If count data ada atau tidak -->
            @foreach ($prosesi_all as $pr_al)
                <h4 class="mb-3">{{$pr_al->nama_status}}</h4>
                @if (!empty($pr_al->det_prosesi))
                    @foreach ($pr_al->det_prosesi as $item)
                        @if ($pr_al->id_status == $item->id_status)
                            <ul class="timeline mb-5">
                                <li>
                                    <a href="/kategori_pengguna/prosesi/{{$item->id_post}}/{{$item->id_parent_post}}">{{$item->nama_post}}</a>
                                </li>
                            </ul>
                        @endif
                    @endforeach
                @else
                    <div class="text-muted mb-5">
                        <em>Tidak ada prosesi.</em>
                    </div>
                @endif
                <!-- Else count kosong -->
            @endforeach
        </div>
    </div>
</div>
<script src="{{asset('/assets/select2/select2.min.js')}}"></script>


@endsection