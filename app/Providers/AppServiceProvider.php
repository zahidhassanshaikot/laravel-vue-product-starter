<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use zahidhassanshaikot\Settings\Facades\Settings;

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
        try {
            Schema::defaultStringLength(191);
            $settings =Settings::all([
                'key', 'value'
            ])->keyBy('key')
                ->transform(function ($setting) {
                    return $setting->value;
                })
                ->toArray();
            config([
                'settings' => $settings
            ]);
            if(config('settings.timezone') != null){
                config([
                    'app.timezone' => config('settings.timezone')
                ]);
            }
        }catch (\Exception $exception){
            Log::debug('App service provider boot method config error: =>'.$exception->getMessage());
        }
    }
}
