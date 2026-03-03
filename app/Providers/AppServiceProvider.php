<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share site settings globally
        view()->composer('*', function ($view) {
            $settings = \Cache::rememberForever('site_settings', function () {
                return \App\Models\SiteSetting::all()->pluck('value', 'key');
            });
            $view->with('siteSettings', $settings);
        });

        view()->composer(['partials.header', 'home'], function ($view) {
            $view->with('activeInitiatives', \App\Models\Initiative::where('is_active', true)->orderBy('sort_order')->get());
        });
    }
}
