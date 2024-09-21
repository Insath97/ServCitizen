<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\SettingInfo;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* use any wahere in system */
        $setting = SettingInfo::pluck('value','key')->toArray();

        View::composer('*', function ($view) use ($setting) {
            $view->with('setting', $setting);
        });
    }
}
