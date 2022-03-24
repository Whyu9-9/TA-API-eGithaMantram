<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/"><strong><span class="text-primary">E-</span>YADNYA</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Yadnya
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($data['kategori'] as $kat)
                        <a class="dropdown-item" href="/kategori_pengguna/{{$kat->id_kategori}}">{{$kat->nama_kategori}}</a>
                        @endforeach
                    </div>
                </li>
                @foreach($data['tag'] as $tg)
                <li class="nav-item">
                    <a href="/tag_pengguna/{{$tg->id_tag}}" class="nav-link">{{$tg->nama_tag}}</a>
                </li>
                @endforeach
            </ul>
                <form class="form-inline ml-auto" action="/pengguna/searching" method="POST">
                    {{ csrf_field() }}
                    <input class="form-control form-control-sm" type="search" name="cari" placeholder="Cari sesuatu..." aria-label="Search">
                </form>
        </div>
    </div>
</nav>