<?php

namespace App\Providers;

use App\Models\ChCategory;
use App\Observers\ChCategoryObserver;
use Illuminate\Support\ServiceProvider;

class ChCategoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        ChCategory::observe(ChCategoryObserver::class);
    }
}
