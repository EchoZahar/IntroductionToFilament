<?php

namespace App\Contracts\PortalData;

interface DeliveryAddressesContract
{
    /**
     * Update or create market delivery addresses
     * @param array $addresses
     * @return void
     */
    public function handle(int $marketID, array $addresses): void;
}
