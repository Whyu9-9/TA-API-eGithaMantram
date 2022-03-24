@extends('pengguna/layouts.app')

@section('konten')
<div class="container pt-5">
    <h1 class="text-center mb-5">Hasil Pencarian</h1>
    @if (count($pencarian) === 0)
    <div class="text-center">
        <img src="/assets/images/empty.svg" alt="" width="480">
        <h5 class="my-5 text-muted">Data yang anda cari tidak ada.</h5>
    </div>
    @endif
        @foreach ($pencarian as $p)
            <div class="card shadow rounded-lg mb-5">
                <div class="row">
                    <div class="col-lg-3">
                        @if ($p['gambar']!='')
                            <img src="/gambarku/{{$p->gambar}}" alt="{{$p->nama_post}}" class="card-img-top">
                        @else
                            
                            <img src="/assets/images/placeholder.png" alt="" class="card-img-top">
                        @endif
                    </div>
                    @if ($p['id_kategori']!='' || empty($p['id_tag']))
                    <div class="card-body col-lg-9 pl-0">
                        <h4>
                            <a href="/kategori_pengguna/detil/{{$p->id_post}}/{{$p->id_kategori}}" class="card-link stretched-link"></a>
                            {{$p->nama_post}}
                        </h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <i class="fa fa-file mr-1"></i>
                                <small>Golongan {{$p->nama_kategori}}</small>
                            </div>
                        </div>
                        <p>
                            @if (strlen($p['deskripsi']) > 250)
                                {!! substr($p['deskripsi'],0,200) !!}...
                            @else
                                {!! substr($p['deskripsi'],0,50) !!}...
                            @endif
                        </p>
                    </div>
                    @elseif ($p['id_tag']!='')
                    <div class="card-body col-lg-9 pl-0">
                        <h4>
                            <a href="/tag_pengguna/detil/{{$p->id_post}}/{{$p->id_tag}}" class="card-link stretched-link"></a>
                            {{$p->nama_post}}
                        </h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <i class="fa fa-file mr-1"></i>
                                <small>Golongan {{$p->nama_tag}}</small>
                            </div>
                        </div>
                        <p>
                            @if (strlen($p['deskripsi']) > 250)
                                {!! substr($p['deskripsi'],0,200) !!}...
                            @else
                                {!! substr($p['deskripsi'],0,50) !!}...
                            @endif
                        </p>
                    </div>
                    @else
                    <div class="card-body col-lg-9 pl-0">
                        <h4>
                            <a href="/tag_pengguna/detil/{{$p->id_post}}/{{$p->id_tag}}" class="card-link stretched-link"></a>
                            {{$p->nama_post}}
                        </h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <i class="fa fa-file mr-1"></i>
                                <small>Golongan {{$p->nama_tag}}</small>
                            </div>
                        </div>
                        <p>
                            @if (strlen($p['deskripsi']) > 250)
                                {!! substr($p['deskripsi'],0,200) !!}...
                            @else
                                {!! substr($p['deskripsi'],0,50) !!}...
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
    <div class="text-center">
        {{$pencarian->links()}}
    </div>
</div>
@endsection