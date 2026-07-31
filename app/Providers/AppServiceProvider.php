<?php

namespace App\Providers;

use App\Helpers\DateHelper;
use App\Services\LayoutService;
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
        View::share('bulanIndo', DateHelper::BULAN_INDO);

        View::composer(['layouts.websites', 'websites.*'], function ($view) {
            $layoutService = app(LayoutService::class);
            $view->with($layoutService->getLayoutData());
        });
    }
}
