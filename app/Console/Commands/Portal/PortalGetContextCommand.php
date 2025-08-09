<?php

namespace App\Console\Commands\Portal;

use App\Models\Market;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Contracts\PortalData\TypesContract;
use App\Methods\Portal\GetPortalContextMethod;
use App\Contracts\PortalData\WarehouseContract;
use App\Contracts\PortalData\AgreementsContract;
use App\Contracts\PortalData\DeliveryTypesContract;
use App\Contracts\PortalData\DeliveryAddressesContract;
use App\Contracts\PortalData\OrderProductStatusesContract;

class PortalGetContextCommand extends Command
{
    public function __construct(
        public readonly GetPortalContextMethod          $method,
        public readonly OrderProductStatusesContract    $productStatuses,
        public readonly AgreementsContract              $agreements,
        public readonly DeliveryAddressesContract       $deliveryAddresses,
        public readonly TypesContract                   $types,
        public readonly DeliveryTypesContract           $deliveryTypes,
        public readonly WarehouseContract               $warehouses,
    )
    {
        parent::__construct();
    }

    protected $signature    = 'portal:getContext {marketID}';

    protected $description  = 'Get portal context: credit, current balance, order statuses, delivery types, user agreements, delivery addresses, return types.';

    public function handle(): int
    {
        try {
            $market = Market::query()->firstWhere('id', '=', $this->argument('marketID'));

            if (isset($market->portal_hash) and !empty($market->portal_hash)) {
                $response = $this->method->method($market->portal_hash);
                if (is_object($response)) {
                    // Update portal order product statuses
                    if (isset($response->order_product_statuses)) $this->productStatuses->handle($market->id, $response->order_product_statuses);
                    // Portal user agreements
                    if (isset($response->user_agreements)) $this->agreements->handle($market->id, $response->user_agreements);
                    // Portal delivery addresses
                    if (isset($response->user_delivery_addresses)) $this->deliveryAddresses->handle($market->id, $response->user_delivery_addresses);
                    // Portal return types
                    if (isset($response->return_types)) $this->types->handle($market->id, $response->return_types);
                    // Portal delivery types
                    if (isset($response->delivery_types)) $this->deliveryTypes->handle($market->id, $response->delivery_types);
                    // Portal warehouses
                    if (isset($response->warehouses)) $this->warehouses->handle($market->id, $response->warehouses);

                    // $this->updatePortalData($market->id, $response);
                    return self::SUCCESS;
                } else {
                    Log::errors('Portal response not found ! C heck this: ' . __METHOD__);
                    throw new \Exception('Portal response not found !');
                }
            } else {
                Log::error('Portal hash not define !');
                throw new \Exception('Portal hash not define !');
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . ' ' . $e->getMessage());
        } finally {
            return self::INVALID;
        }
    }

    // private function updatePortalData(int $marketID, object $response)
    // {

        // Portal delivery addresses
        // if (isset($response->user_delivery_addresses)) {
        //     $this->deliveryAddresses->deliveryAddress($response->user_delivery_addresses);
        //     // foreach ($response->user_delivery_addresses  as $dAddress) {
        //     //     PortalUserDeliveryAddress::query()->updateOrCreate([
        //     //         'market_id' => $marketID,
        //     //         'uda_id'    => $dAddress->uda_id
        //     //     ], [
        //     //         'uuid'      => $dAddress->uuid,
        //     //         'address'   => $dAddress->address
        //     //     ]);
        //     // }
        // }

        // Portal return types
        // if (isset($response->return_types))
        //     $this->types->types($response->return_types);
            // foreach ($response->return_types as $rType) {
            //     PortalReturnType::query()->updateOrCreate([
            //         'market_id' => $marketID,
            //         'type_id'   => $rType->id
            //     ], [
            //         'name' => $rType->name
            //     ]);
            // }
        // }

        // Portal delivery types
        // if (isset($response->delivery_types)) {
            // foreach ($response->delivery_types as $dType) {
            //     PortalDeliveryType::query()->updateOrCreate([
            //         'market_id' => $marketID,
            //         'dt_id'     => $dType->dt_id
            //     ], [
            //         'name' => $dType->name
            //     ]);
            // }
        // }
        // Portal warehouses
        // if (isset($response->warehouses)) {
            // foreach ($response->warehouses as $wh) {
            //     PortalWarehouse::query()->updateOrCreate([
            //         'market_id' => $marketID,
            //         'wh_id'     => $wh->wh_id
            //     ], [
            //         'name' => $wh->name
            //     ]);
            // }
        // }
    // }
}
