<!DOCTYPE html>
<html class="with-background">
<body>
@extends('pengguna/layouts.app')

@section('konten')

<div class="container py-5">
    <h1 class="text-center mb-5 text-white">E-Upacara</h1>
    <form action="#" class="form mb-5">
        <div class="input-group">
            <input class="form-control" placeholder="Cari..." name="cari">
            <span class="input-group-append">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-search">Cari</i>
                </button>
            </span>
        </div>
    </form>
    <!--Carousel Wrapper-->
    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">
    <!--Indicators-->
    <ol class="carousel-indicators">
        @foreach($data['kategori'] as $kat)
      <li data-target="#multi-item-example" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
      @endforeach
    </ol>
    
    <!--/.Indicators-->
        <!--Slides-->
        <div class="carousel-inner" role="listbox">
        @foreach($data['kategori'] as $kat)
        <!--First slide-->
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="col-md-3" style="float:left">
                    <div class="card mb-5">
                        <div class="card-body">
                            <h4 class="card-title">{{$kat->nama_kategori}}</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a class="btn btn-primary">Button</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    <!--/.Slides-->
    </div>
    <a class="carousel-control-prev" href="#multi-item-example" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#multi-item-example" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
  <!--/.Carousel Wrapper-->

<script type="text/javascript"> 
    $(window).load(function() { 
        $(".carousel .item").each(function() { 
            var i = $(this).next(); 
            i.length || (i = $(this).siblings(":first")), 
              i.children(":first-child").clone().appendTo($(this)); 
            
            for (var n = 0; n < 4; n++)(i = i.next()).length || 
              (i = $(this).siblings(":first")), 
              i.children(":first-child").clone().appendTo($(this)) 
        }) 
    }); 
</script> 

@endsection