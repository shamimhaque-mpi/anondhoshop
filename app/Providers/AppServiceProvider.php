<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Interfaces\Admin;
use App\Repositories\AdminInfo;

use App\Interfaces\Setting;
use App\Repositories\Settings;

use App\Interfaces\Image;
use App\Repositories\Images;

use App\Interfaces\Model;
use App\Repositories\Models;

use App\Interfaces\Product;
use App\Repositories\Products;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Model::class,   Models::class);
        $this->app->singleton(Image::class,   Images::class);
        $this->app->singleton(Admin::class,   AdminInfo::class);
        $this->app->singleton(Setting::class, Settings::class);
        $this->app->singleton(Product::class, Products::class);
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
