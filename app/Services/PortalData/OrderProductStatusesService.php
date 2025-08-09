<?php

namespace App\Services\PortalData;

use App\Models\PortalOrderProductStatus;
use App\Contracts\PortalData\OrderProductStatusesContract;

class OrderProductStatusesService implements OrderProductStatusesContract
{
    public function handle(int $marketID, array $statuses): void
    {
        foreach ($statuses as $pStatuses) {
            PortalOrderProductStatus::updateOrCreate([
                'market_id' => $marketID,
                'ops_id'    => $pStatuses->ops_id
            ], [
                'name' => $pStatuses->name
            ]);
        }
    }
}
