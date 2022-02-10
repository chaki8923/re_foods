<?php

namespace App\Providers;

use Doctrine\DBAL\Schema\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Address;
use App\Board;
use App\Category;
use App\Food;
use App\Message;
use App\Store;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         # 商用環境以外だった場合、SQLログを出力させます
         if (config('app.env') !== 'production') {
            DB::listen(function ($query) {
                Log::info("Query Time:{$query->time}s] $query->sql");
            });
        }
    
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
      
    }
}
