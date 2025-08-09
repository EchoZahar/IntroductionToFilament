<?php

namespace App\Contracts\PortalData;

interface DeliveryTypesContract
{
    /**
     * Portal - market delivery types.
     * @param array $deliveryTypes
     * @return void
     */
    public function handle(int $marketID, array $deliveryTypes): void;
}
