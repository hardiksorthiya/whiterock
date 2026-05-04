<?php

namespace App\Providers;

use App\Models\ProductCategory;
use App\Models\Setting;
use App\View\Composers\FrontendLayoutSeoComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('frontend.layouts.app', FrontendLayoutSeoComposer::class);

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
