<?php

namespace App\Providers;

use App\Models\ProductCategory;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // ✅ SAFE SETTINGS LOAD
        try {
            if (Schema::hasTable('settings')) {
                view()->share('settings', Setting::first());
            }
        } catch (\Exception $e) {
            // ignore during setup
        }

        // ✅ SAFE FOOTER DATA
        View::composer('frontend.partials.footer', function ($view) {
            try {
                if (Schema::hasTable('product_categories')) {
                    $footerProductCategories = ProductCategory::query()
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get(['id', 'name', 'slug']);

                    $view->with('footerProductCategories', $footerProductCategories);
                }
            } catch (\Exception $e) {
                // ignore during setup
            }
        });
    }
}
