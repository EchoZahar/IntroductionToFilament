<?php

namespace App\Repositories\CardProduct;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\JoinClause;
use App\Contracts\CardProduct\PortalNomenclatureOnReplicaContract;

class PortalNomenclatureOnReplicaRepository implements PortalNomenclatureOnReplicaContract
{
    /**
     * Get goods from our warehouses STV, KRD, RND, MSK
     * @var array
     */
    public array $defaultWarehouses = [1, 1165, 8, 9];

    /**
     * Get new nomenclature from replica portal.
     * @param string $brand
     * @param array $warehouses
     * @param array|null $currentIDs
     * @return Collection|null
     */
    public function getNomenclatureByBrand(string $brand, ?array $currentIDs = []): Collection|null
    {
        $w = $this->defaultWarehouses;
        $portalBrandID   = $this->searchBrand($brand);
        if ($portalBrandID) {
            //
            return DB::connection('pgsql_portal')->table('bs.t_nomenclature as n')
                ->join('bs.t_product as p', function (JoinClause $join) use ($w) {
                        $join->on('p.nomenclature_id', '=', 'n.nomenclature_id')->whereIn('p.warehouse_id', $w);
                    })
                ->leftJoin('bs.t_nomenclature_code as nc', 'n.nomenclature_id', '=', 'nc.nomenclature_id')
                ->leftJoin('bs.t_nomenclature_barcode as nb', function (JoinClause $j) {
                    $j->on('nb.nomenclature_id', '=', 'p.nomenclature_id');
                })
                ->where('n.brand_id', '=', $portalBrandID)
                ->where('n.prices_for_price_levels', '!=', '{}')
                ->where(function ($q) {
                    $q->whereNotNull('n.size_length')->where('n.size_length', '>', '0');
                })
                ->where(function ($q) {
                    $q->whereNotNull('n.size_width')->orWhere('n.size_width', '>', '0');
                })
                ->where(function ($q) {
                    $q->whereNotNull('n.size_height')->orWhere('n.size_height', '>', '0');
                })
                ->where(function ($q) {
                    $q->whereNotNull('n.net_weight')
                        ->where('n.net_weight', '!=', 0.0)->where('n.net_weight', '<=', '24.5');
                })
                ->whereNotIn('n.nomenclature_id', $currentIDs)
                ->select('n.*', 'nb.barcode',
                        'nc.tnved', 'nc.okpd2',
                        'p.product_id', 'p.warehouse_id', 'p.price as original_price', 'p.price_netto as cost_price')
                ->get();
        }
        return null;
    }

    public function searchBrand(string $search): int|null
    {
        try {
            return DB::connection('pgsql_portal')
                ->table('bs.t_brand')
                ->where('brand_name', '=', strtoupper($search))
                ->select('brand_id')
                ->first()->brand_id;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . ' ' . $e->getMessage());
            throw new \Exception('Что то пошло не так ! "' . $search . '" не определен, смотри логи.' );
        }
    }
}
