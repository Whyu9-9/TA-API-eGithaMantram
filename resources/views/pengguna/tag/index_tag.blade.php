@extends('pengguna/layouts.app')

@section('konten')
<div class="container pt-5">
    @foreach ($tag as $t)
        @if ($loop->first)
        <h1 class="text-center mb-5">{{$t->nama_tag}}</h1>
        @endif
    @endforeach
    @if (count($tag) === 0)
    <div class="text-center">
        <img src="assets/images/empty.svg" alt="" width="480">
        <h5 class="my-5 text-muted">Tidak ada data.</h5>
    </div>
    @endif
        @foreach ($tag as $tg)
            <div class="card shadow rounded-lg mb-5">
                <div class="row">
                    <div class="col-lg-3">
                        @if ($tg['gambar']!='')
                            <img src="/gambarku/{{$tg->gambar}}" alt="{{$tg->nama_post}}" class="card-img-top">
                        @else
                            <img src="/assets/images/placeholder.png" alt="" class="card-img-top">
                        @endif
                    </div>
                    <div class="card-body col-lg-9 pl-0">
                        <h4>
                            <a href="/tag_pengguna/detil/{{$tg->id_post}}/{{$tg->id_tag}}" class="card-link stretched-link"></a>
                            {{$tg->nama_post}}
                        </h4>
                        {{-- <div class="row">
                            <div class="col-lg-3">
                                <i class="fa fa-file mr-1"></i>
                                <small>Golongan {{$tg->nama_tag}}</small>
                            </div>
                        </div> --}}
                        <p>
                            @if (strlen($tg['deskripsi']) > 250)
                                {!! substr($tg['deskripsi'],0,200) !!}...
                            @else
                                {!! substr($tg['deskripsi'],0,50) !!}...
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    <div class="text-center">
        {{$tag->links()}}
    </div>
</div>
@endsection