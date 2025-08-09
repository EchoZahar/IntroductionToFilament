<?php

namespace App\Services\CardProduct\NewNomenclature;

use App\Models\ChCategory;
use App\Models\CardProduct;
use App\Models\CardProductPricing;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CardProductDimensions;
use App\Enum\CardProduct\CardStatusEnum;
use App\Enum\CardProduct\MultiplicityEnum;
use App\Traits\CardProduct\DimensionConverter\CardConverter;

class HandleNewNomenclature
{
    use CardConverter;

    public function checkAndHandle(string $brand, Collection $newNomenclature): void
    {
        foreach ($newNomenclature as $n) {
            // check article to USED
            if (!str_contains($n->article, 'USED')) {
                // clear article
                $article    = trim($n->article, " \n\r\t\v\x00");
                // clear brand and remove symbols
                $brand      = strtoupper(str_replace(['/', ' '], '', $brand));
                // create unique key
                $uniqStr    = trim(strtoupper(str_replace(' ', '_', $brand) . '|'. $article), " \n\r\t\v\x00");
                if ($this->checkUniqKey($uniqStr) === false) {
                    // check dimensions
                    $dimensions = $this->checkDimension($n);
                    if (!empty($dimensions)) {
                        // create card product array
                        $cardProduct = $this->createCardProductArray($n, $brand);
                        $cardProduct['unique_key']      = $uniqStr;
                        $cardProduct['brand']           = $brand;
                        // check and handle pricing
                        $pricing                        = $this->checkPrices($n->prices_for_price_levels);
                        $pricing['cost_price']          = (float)$n->cost_price;
                        $pricing['original_price']      = (int)$n->original_price;
                        $this->createNewCardProduct($cardProduct, $dimensions, $pricing);
                    }
                }
            }
        }
    }

    private function createNewCardProduct(array $card, array $dimensions, array $pricing): void
    {
        try {
            DB::transaction(function() use ($card, $dimensions, $pricing) {
                $newCard = CardProduct::query()->create($card);
                if ($newCard) {
                    $dimensions['card_product_id'] = $newCard->id;
                    CardProductDimensions::query()->create($dimensions);

                    $pricing['card_product_id'] = $newCard->id;
                    CardProductPricing::query()->create($pricing);
                }
            });
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error: ' . $e->getMessage() . ' line:' . $e->getLine() . ' ' . __METHOD__);
            throw new \Exception($e->getMessage());
        }
    }

    private function checkPrices(string $prices): array|null
    {
        $prices = json_decode($prices);
        if (is_object($prices)) {
            $prices = get_object_vars($prices);
            if (!empty($prices)) {
                return [
                    'market_price'      => (float)$prices[4],
                    'vip_three'   => (float)$prices[7],
                    'three_price'       => (float)$prices[1],
                ];
            }
            return null;
        }
        return null;
    }

    private function createCardProductArray(object $nomenclature, string $brand): array
    {
        if ($nomenclature->mult_sale === 1) {
            $multi = MultiplicityEnum::ONE;
        } else {
            $multi = MultiplicityEnum::SET;
        }
        $card['portal_nomenclature_id'] = $nomenclature->nomenclature_id;
        $card['ch_category_id']         = ($nomenclature->nom_type_id) ? ChCategory::query()->where('portal_id', '=', $nomenclature->nom_type_id)->first()?->id : null;
        $card['name']                   = $nomenclature->nom_name;
        $card['description']            = $nomenclature->description;
        $card['article']                = $nomenclature->article;
        $card['barcode']                = $nomenclature->barcode;
        $card['multiplicity']           = $multi;
        $card['multiplicity_sale']      = $nomenclature->mult_sale;
        $card['status']                 = CardStatusEnum::NEW;
        $card['tnved']                  = $nomenclature->tnved;
        $card['okpd2']                  = $nomenclature->okpd2;

        return $card;
    }

    private function checkDimension(object $n): array
    {
        $convert['length']      = $this->convertMeterToMmtSize((float)$n->size_length ?? 0.0);
        $convert['width']       = $this->convertMeterToMmtSize((float)$n->size_width ?? 0.0);
        $convert['height']      = $this->convertMeterToMmtSize((float)$n->size_height ?? 0.0);
        $convert['net_weight']  = $this->convertKiloToGrWeight((float)$n->net_weight ?? 0.0);
        if (!is_null($n->gross_weight)) {
            $convert['gross_weight'] = $this->convertKiloToGrWeight((float)$n->gross_weight ?? 0);
        } else {
            $convert['gross_weight'] = 0;
        }
        if ($convert['length'] > 0 and $convert['width'] > 0 and $convert['height'] and $convert['net_weight']) {
            $convert['is_kgt']          = ($convert['net_weight'] > 24.5) ? true : false;
            $convert['volume']          = $this->calculateVolume($convert['width'], $convert['height'], $convert['length']);
            $convert['volume_weight']   = $this->calculateVolumeWeight($convert['width'], $convert['height'], $convert['length']);
            $convert['volume_liter']    = $this->calculateVolumeLiter($convert['width'], $convert['height'], $convert['length']);
            return $convert;
        }
        return [];
    }

    private function checkUniqKey(string $key): bool
    {
        return DB::table('card_products')->where('unique_key', '=', $key)->exists();
    }
}
