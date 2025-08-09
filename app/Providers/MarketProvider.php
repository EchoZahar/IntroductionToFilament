<?php

namespace App\Providers;

use App\Models\Market;
use App\Observers\MarketObserver;
use Illuminate\Support\ServiceProvider;
use App\Services\PortalData\TypesService;
use App\Contracts\PortalData\TypesContract;
use App\Services\PortalData\WarehouseService;
use App\Services\PortalData\AgreementsService;
use App\Contracts\PortalData\WarehouseContract;
use App\Contracts\PortalData\AgreementsContract;
use App\Services\PortalData\DeliveryTypesService;
use App\Contracts\PortalData\DeliveryTypesContract;
use App\Services\PortalData\DeliveryAddressesService;
use App\Contracts\PortalData\DeliveryAddressesContract;
use App\Services\PortalData\OrderProductStatusesService;
use App\Contracts\PortalData\OrderProductStatusesContract;

class MarketProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderProductStatusesContract::class, OrderProductStatusesService::class);
        $this->app->bind(AgreementsContract::class, AgreementsService::class);
        $this->app->bind(DeliveryAddressesContract::class, DeliveryAddressesService::class);
        $this->app->bind(TypesContract::class, TypesService::class);
        $this->app->bind(DeliveryTypesContract::class, DeliveryTypesService::class);
        $this->app->bind(WarehouseContract::class, WarehouseService::class);
    }

    public function boot(): void
    {
        Market::observe(MarketObserver::class);
    }
}
