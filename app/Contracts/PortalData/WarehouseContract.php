<?php

namespace App\Contracts\PortalData;

interface WarehouseContract
{
    public function handle(int $marketID, array $data): void;
}
