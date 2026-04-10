<?php

namespace App\Providers;

use App\Models\ProductCategory;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        Paginator::useBootstrapFive();
        view()->share('settings', Setting::first());

        View::composer('frontend.partials.footer', function ($view) {
            $footerProductCategories = ProductCategory::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'slug']);

            $view->with('footerProductCategories', $footerProductCategories);
        });
    }
}
