<?php

namespace App\Services\PortalData;

use App\Models\PortalWarehouse;
use App\Contracts\PortalData\WarehouseContract;

class WarehouseService implements WarehouseContract
{
    public function handle(int $marketID, array $data): void
    {
        foreach ($data as $wh) {
            PortalWarehouse::query()->updateOrCreate([
                'market_id' => $marketID,
                'wh_id'     => $wh->wh_id
            ], [
                'name' => $wh->name
            ]);
        }
    }
}
