<?php

namespace App\Contracts\PortalData;

interface OrderProductStatusesContract
{
    public function handle(int $marketID, array $statuses): void;
}
