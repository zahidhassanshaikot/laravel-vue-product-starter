<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
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
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
        $this->loadAndSetSettings();
    }


    private function loadAndSetSettings(): void
    {
        try {
            $settings = $this->getCachedSettings();
            $this->setConfigSettings($settings);
            $this->setAppTimezone($settings);
        } catch (\Exception $exception) {
            $this->logException($exception);
        }
    }

    private function getCachedSettings(): array
    {
        return Cache::rememberForever('system_settings', function () {
            return Settings::all()->keyBy('key')
                ->transform(function ($setting) {
                    return $setting->value;
                })
                ->toArray();
        });
    }

    private function setConfigSettings(array $settings): void
    {
        Config::set('settings', $settings);
    }

    private function setAppTimezone(array $settings): void
    {
        if (isset($settings['timezone'])) {
            config([
                'app.timezone' => $settings['timezone']
            ]);
        }
    }

    private function logException(\Exception $exception): void
    {
        Log::debug('App service provider boot method config error: ' . $exception->getMessage());
    }
}
