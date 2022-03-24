@extends('pengguna/layouts.app')

@section('konten')
<div class="container pt-5">
    @foreach ($kategori as $k)
        @if ($loop->first)
        <h1 class="text-center mb-5">{{$k->nama_kategori}}</h1>
        @endif
    @endforeach
    @if (count($kategori) === 0)
    <div class="text-center">
        <img src="/assets/images/empty.svg" alt="" width="480">
        <h5 class="my-5 text-muted">Tidak ada data.</h5>
    </div>
    @endif
        @foreach ($kategori as $kt)
            <div class="card shadow rounded-lg mb-5">
                <div class="row">
                    <div class="col-lg-3">
                        @if ($kt['gambar']!='')
                            <img src="/gambarku/{{$kt->gambar}}" alt="{{$kt->nama_post}}" class="card-img-top">
                        @else
                            <img src="/assets/images/placeholder.png" alt="" class="card-img-top">
                        @endif
                    </div>
                    <div class="card-body col-lg-9 pl-0">
                        <h4>
                            <a href="/kategori_pengguna/detil/{{$kt->id_post}}/{{$kt->id_kategori}}" class="card-link stretched-link"></a>
                            <p style="color:blue">{{$kt->nama_post}}</p>
                        </h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <i class="fa fa-file mr-1"></i>
                                <small>Golongan {{$kt->nama_kategori}}</small>
                            </div>
                        </div>
                        <p>
                            @if (strlen($kt['deskripsi']) > 250)
                                {!! substr($kt['deskripsi'],0,200) !!}...
                            @else
                                {!! substr($kt['deskripsi'],0,50) !!}...
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    <div class="text-center">
        {{$kategori->links()}}
    </div>
</div>
@endsection