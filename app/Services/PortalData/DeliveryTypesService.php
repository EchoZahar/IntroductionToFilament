<?php

namespace App\Services\PortalData;

use App\Models\PortalDeliveryType;
use App\Contracts\PortalData\DeliveryTypesContract;

class DeliveryTypesService implements DeliveryTypesContract
{
    public function handle(int $marketID, array $deliveryTypes): void
    {
        foreach ($deliveryTypes as $dType) {
            PortalDeliveryType::query()->updateOrCreate([
                'market_id' => $marketID,
                'dt_id'     => $dType->dt_id
            ], [
                'name' => $dType->name
            ]);
        }
    }
}
