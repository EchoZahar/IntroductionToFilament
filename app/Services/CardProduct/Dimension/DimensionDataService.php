<?php

namespace App\Services\CardProduct\Dimension;

use App\Models\CardProductDimension;
use App\Models\User;
use App\Traits\CardProduct\DimensionConverter\CardConverter;
use Illuminate\Support\Facades\Log;

class DimensionDataService
{
    use CardConverter;

    /**
     * ОБРАБОТКА ПЕРЕД ОБНОВЛЕНИЕМ ВГХ.
     * length, width, height, net_weight, gross_weight
     * @param array $dimensions
     * @param CardProductDimension|null $record
     * @param User|null $user
     * @return void
     */
    public function processData(array $dimensions, ?CardProductDimension $record = null, ?User $user = null): void
    {
        if ($record) {
            // Check gross weight.
            $dimensions['gross_weight'] = $this->checkGrossWeight($dimensions['net_weight'], $dimensions['gross_weight']);
            // Check large-sized goods.
            $dimensions['is_kgt']       = $this->isKgt($dimensions['gross_weight']);
            // Calculate volumes.
            $dimensions = $this->calculateVolumes($dimensions);
            // Update dimensions.
            $record->update($dimensions);
            Log::info('User ' . $user->name . ' update card dimensions, id: ' . $record->id);
        } else {
            Log::error('Record dimensions not found ! User: ' . $user?->id);
        }

    }

    /**
     * Calculate volumes.
     * @param array $d
     * @return array
     */
    private function calculateVolumes(array $d): array
    {
        $l = $d['length'];
        $w = $d['width'];
        $h = $d['height'];
        $d['volume'] = $this->calculateVolume($w, $h, $l);
        $d['volume_weight'] = $this->calculateVolumeWeight($w, $h, $l);
        $d['volume_liter']  = $this->calculateVolumeLiter($w, $h, $l);
        return $d;
    }

    /**
     * Check gross weight.
     * @param int $netWeight
     * @param int $grossWeight
     * @return int
     */
    private function checkGrossWeight(int $netWeight, int $grossWeight): int
    {
        if ($grossWeight === 0 || $grossWeight<= $netWeight) {
            $grossWeight = $netWeight * 1.1;
        }
        return $grossWeight;
    }

    /**
     * Check large-sized goods.
     * @param int $grossWeight
     * @return bool
     */
    private function isKgt(int $grossWeight): bool
    {
        if ($grossWeight > 24999) return true;
        return false;
    }
}