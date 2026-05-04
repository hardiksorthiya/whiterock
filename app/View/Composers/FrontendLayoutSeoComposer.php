<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class FrontendLayoutSeoComposer
{
    public function compose(View $view): void
    {
        $defaults = config('frontend_seo.defaults', []);
        if (! is_array($defaults)) {
            $defaults = [];
        }

        $byRoute = config('frontend_seo.by_route', []);
        if (! is_array($byRoute)) {
            $byRoute = [];
        }

        $routeName = Route::currentRouteName();
        $entry = $routeName !== null && isset($byRoute[$routeName]) && is_array($byRoute[$routeName])
            ? $byRoute[$routeName]
            : null;

        $merged = array_merge($defaults, $entry ?? []);

        if ($entry !== null) {
            $merged = $this->interpolate($merged, $view, $routeName);
        }

        $view->with('globalSeo', $merged);
    }

    /**
     * @param  array<string, string>  $seo
     * @return array<string, string>
     */
    protected function interpolate(array $seo, View $view, ?string $routeName): array
    {
        $replacements = [];

        if ($routeName === 'product-category.show' && $view->offsetExists('category')) {
            $replacements['{category}'] = (string) ($view['category']->name ?? '');
        }

        if ($routeName === 'gallery.application.show' && $view->offsetExists('application')) {
            $replacements['{application}'] = (string) ($view['application']->name ?? '');
        }

        if ($routeName === 'catalogue-category.show' && $view->offsetExists('selectedCatalogueCategory') && $view['selectedCatalogueCategory'] !== null) {
            $replacements['{catalogueCategory}'] = (string) ($view['selectedCatalogueCategory']->name ?? '');
        }

        if ($replacements === []) {
            return $seo;
        }

        foreach ($seo as $key => $value) {
            if (is_string($value)) {
                $seo[$key] = strtr($value, $replacements);
            }
        }

        return $seo;
    }
}
