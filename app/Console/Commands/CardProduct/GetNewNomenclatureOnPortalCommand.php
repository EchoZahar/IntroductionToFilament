<?php

namespace App\Console\Commands\CardProduct;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Contracts\CardProduct\PortalNomenclatureOnReplicaContract;
use App\Services\CardProduct\NewNomenclature\HandleNewNomenclature;
use Illuminate\Support\Facades\Log;

class GetNewNomenclatureOnPortalCommand extends Command
{
    protected $signature = 'cp:getNewNomenclature {brandName?}';

    protected $description = 'Get new nomenclature on portal';

    public function __construct(
        public readonly PortalNomenclatureOnReplicaContract $getNomenclature,
        public readonly HandleNewNomenclature $handleNewNomenclatureService
    )
    {
        parent::__construct();
        // $priorityBrands = ['ENOC', 'ABSEL', 'PETRONAS', 'MOBIL'];
    }

    public function handle(): void
    {
        try {
            $brandName = (!empty($this->argument('brandName'))) ? $this->argument('brandName') : null;

            if ($brandName) {
                $newNomenclature = $this->getNomenclature->getNomenclatureByBrand($brandName, $this->getCurrentNomenclatureIDs($brandName));
                if ($newNomenclature) {
                    $newNomenclature->count() === 0 ?: $this->handleNewNomenclatureService->checkAndHandle($brandName, $newNomenclature);
                }
            }
            else {
                $defaultBrands = ['ENOC', 'ABSEL', 'PETRONAS', 'MOBIL'];
                foreach ($defaultBrands as $brandName) {
                    $newNomenclature = $this->getNomenclature->getNomenclatureByBrand($brandName, $this->getCurrentNomenclatureIDs($brandName));
                    if ($newNomenclature) {
                        $newNomenclature->count() === 0 ?: $this->handleNewNomenclatureService->checkAndHandle($brandName, $newNomenclature);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' line: ' . $e->getLine() . ' ' . __METHOD__);
            dd($e->getMessage() . ' ' . $e->getLine());
        }
    }

    private function getCurrentNomenclatureIDs(string $brand): array
    {
        return DB::table('card_products')
            ->where('brand', '=', $brand)
            ->select('portal_nomenclature_id')
            ->pluck('portal_nomenclature_id')
            ->toArray();
    }
}
