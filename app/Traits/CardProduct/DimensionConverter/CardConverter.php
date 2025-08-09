<?php

namespace App\Traits\CardProduct\DimensionConverter;

trait CardConverter
{
    /**
     * Convert nomenclature metres to mm dimension.
     * @param float $size
     * @return int
     */
    public function convertMeterToMmtSize(float $size): int
    {
        return (int)round($size * 1000);
    }

    /**
     * Convert nomenclature kg to g weight dimension.
     * @param float $weight
     * @return int
     */
    public function convertKiloToGrWeight(float $weight): int
    {
        return (int)round($weight * 1000);
    }

    /**
     * Calculate volume product.
     * @param int $w
     * @param int $h
     * @param int $l
     * @return float
     */
    public function calculateVolume(int $w, int $h, int $l): float
    {
        return round(($w / 1000) * ($h / 1000) * ($l / 1000), 6);
    }

    /**
     * Calculate volume weight product.
     * @param float $w
     * @param float $h
     * @param float $l
     * @return float
     */
    public function calculateVolumeWeight(int $w, int $h, int $l): float
    {
        return round((($w * $h * $l) / 1000000 / 5), 3);
    }

    /**
     * Calculate volume liters product.
     * @param int $w
     * @param int $h
     * @param int $l
     * @return float
     */
    public function calculateVolumeLiter(int $w, int $h, int $l): float
    {
        return round(($w * $h * $l) / 1000000, 3);
    }
}
