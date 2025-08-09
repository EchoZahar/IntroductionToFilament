<?php

namespace App\Providers;

use App\Models\CardProduct;
use App\Observers\CardProductObserver;
use Illuminate\Support\ServiceProvider;
use App\Contracts\CardProduct\PortalNomenclatureOnReplicaContract;
use App\Repositories\CardProduct\PortalNomenclatureOnReplicaRepository;

class CardProductProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PortalNomenclatureOnReplicaContract::class, PortalNomenclatureOnReplicaRepository::class);
    }

    public function boot(): void
    {
        CardProduct::observe(CardProductObserver::class);
    }
}
