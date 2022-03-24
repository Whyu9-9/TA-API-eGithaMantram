<!DOCTYPE html>
<html class="with-background">
<body>
@extends('pengguna/layouts.app')

@section('konten')
<div class="container py-5">
    <h1 class="text-center mb-5 text-white">E-Yadnya</h1>
    <form action="/pengguna/searching" method="POST" class="form mb-5">
        {{ csrf_field() }}
        <div class="input-group">
            <input class="form-control" placeholder="Cari..." name="cari">
            <span class="input-group-append">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-search">Cari</i>
                </button>
            </span>
        </div>
    </form>
    <div class="swiper-container" id="swiper-menu">
        <div class="swiper-wrapper">
            @foreach($data['kategori'] as $kat)
            <div class="swiper-slide">
                <div class="card card-upacara gradient-1 text-center">
                    <div class="card-body">
                        <h1 class="card-title my-5">
                            <a href="/kategori_pengguna/{{$kat->id_kategori}}" class="stretched-link">
                                {{$kat->nama_kategori}}
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>
<script src="{{asset('/assets/swiper/dist/js/swiper.min.js')}}">
// var mySwiper = new Swiper('#swiper-menu', {
//     speed: 400,
//     spaceBetween: 100,
//     effect: 'slide',
//     slidesPerView: 'auto'
// });
//     var mySwiper = document.querySelector('#swiper-menu').swiper

//     mySwiper.slideNext();
var swiper = new Swiper('.card-body', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
    });
</script>
@endsection
</body>
</html>
