<?php

namespace App\Contracts\CardProduct;

use Illuminate\Support\Collection;

interface PortalNomenclatureOnReplicaContract
{
    /**
     * Get new nomenclature.
     * @param string $brand
     * @param array $warehouses
     * @param mixed $currentIDs
     * @return Collection|null
     */
    public function getNomenclatureByBrand(string $brand, ?array $currentIDs = []): Collection|null;
}
