@extends('admin/layouts.app',['data' => $data])

@section('konten')
<div class="row">
    <div class="col-lg-12">
    	<h1 class="page-header">Kategori Yadnya</h1>
	</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel pane-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-2">
                        <a href="/kategori/tambah_kategori" class="btn btn-warning btn-block">
                            <i class="fa fa-plus" style="margin-right:8px"></i>Tambah
                        </a>
                    </div>
                    <div class="col-md-4 col-md-offset-6">
                        <form class="form" action="#" method="GET">
                            <div class="row">
                                <div class="col-lg-8" style="padding-right: 0px">
                                    <input type="text" class="form-control" value="" style="height: inherit" placeholder="Cari..." name="cari">
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-search" style="margin-right: 8px"></i>Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-10 text-right"></div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Yadnya</th>
                        <th>Deskripsi</th>
                        <th width="250">Operasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategori as $kat)
                    <tr>
                        <td>
                            {{$kat->nama_kategori}}
                        </td>
                        <td>
                            {{$kat->deskripsi}}
                        </td>
                        <td>
                            <a href="/kategori/edit_kategoriku/{{ $kat->id_kategori }}" class="btn btn-primary btn-xs"><i class="fa fa-edit" style="margin-right: 4px"></i>Edit</a>
                            <a href="/kategori/hapus_kategoriku/{{ $kat->id_kategori }}" onclick="return confirm('Delete ?')" class="btn btn-danger btn-xs"><i class="fa fa-remove" style="margin-right: 4px">Hapus</i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {{$kategori->links()}}
        </div>
    </div>
</div>
@endsection