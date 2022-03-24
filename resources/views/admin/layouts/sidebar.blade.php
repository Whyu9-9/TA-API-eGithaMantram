<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <div class="profile-sidebar">
        <div class="profile-userpic">
            <img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
        </div>
        <div class="profile-usertitle">
            <div class="profile-usertitle-name">{{Session::get('name')}}</div>
            <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="divider"></div>
    <ul class="nav menu">
        <li>
            <a href="/index">
                <i style="width: 24px" class="fa fa-home">&nbsp;</i>
                <span>Beranda</span>
            </a>
        </li>
        <li>
            <hr />
        </li>
        <li class="parent">
            <a data-toggle="collapse" href="#sub-item-1">
                <i style="width: 24px" class="fa fa-star">&nbsp;</i> Yadnya
                <span data-toggle="collapse" href="#" class="icon pull-right"><i class="fa fa-plus"></i></span>
            </a>
            <ul class="children collapse" id="sub-item-1">
                @foreach($data['kategori'] as $kat)
                <li>
                    <a href="/category/{{$kat->id_kategori}}">{{$kat->nama_kategori}}</a>
                </li>
                @endforeach
                <li>
                    <a href="/kategori/detil_kategoriku"><i class="fa fa-edit" style="margin-right: 4px"></i>Tambah</a>
                </li>
            </ul>
        </li>
        @foreach($data['tag'] as $tg)
        <li>
            <a href="/tags/{{$tg->id_tag}}">
                <i style="width: 24px" class="fa fa-database"></i>
                <span>{{$tg->nama_tag}}</span>
            </a>
        </li>
            @endforeach
        <li>
            <a href="/tag/detil_tagku"><i class="fa fa-edit" style="margin-right: 4px"></i>Tambah</a>
        </li>
        <li>
            <hr />
        </li>
        <li>
            <a href="/admin/operator">
                <i style="width: 24px" class="fa fa-users"></i>
                <span>Operator</span>
            </a>
        </li>
        <li>
            <a href="/logout">
                <i style="width: 24px" class="fa fa-power-off"></i>
                <span>Keluar</span>
            </a>
        </li>
    </ul>
</div>