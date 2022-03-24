<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Kategori;
use App\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $kategori = Kategori::all();
        $tag = Tag::all();
        $data['kategori']=$kategori;
        $data['tag']=$tag;
        view()->share('data', $data);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
