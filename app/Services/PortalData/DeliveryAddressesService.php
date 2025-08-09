<?php

namespace App\Services\PortalData;

use App\Models\PortalUserDeliveryAddress;
use App\Contracts\PortalData\DeliveryAddressesContract;

class DeliveryAddressesService implements DeliveryAddressesContract
{
    public function handle(int $marketID, array $addresses): void
    {
        foreach ($addresses  as $dAddress) {
            PortalUserDeliveryAddress::query()->updateOrCreate([
                'market_id' => $marketID,
                'uda_id'    => $dAddress->uda_id
            ], [
                'uuid'      => $dAddress->uuid,
                'address'   => $dAddress->address
            ]);
        }
    }
}
