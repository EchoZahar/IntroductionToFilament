<?php

namespace App\Services\PortalData;

use App\Models\PortalReturnType;
use App\Contracts\PortalData\TypesContract;

class TypesService implements TypesContract
{
    public function handle(int $marketID, array $types): void
    {
        foreach ($types as $rType) {
            PortalReturnType::query()->updateOrCreate([
                'market_id' => $marketID,
                'type_id'   => $rType->id
            ], [
                'name' => $rType->name
            ]);
        }
    }
}
