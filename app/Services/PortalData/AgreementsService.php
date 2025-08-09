<?php

namespace App\Services\PortalData;

use App\Models\PortalUserAgreement;
use App\Contracts\PortalData\AgreementsContract;

class AgreementsService implements AgreementsContract
{
    /**
     * @inheritDoc
     */
    public function handle(int $marketID, array $agreements): void
    {
        foreach ($agreements as $uAgreement) {
            PortalUserAgreement::query()->updateOrCreate([
                'market_id' => $marketID,
                'ua_id'     => $uAgreement->ua_id,
            ], [
                'uuid'      => $uAgreement->uuid,
                'name'      => $uAgreement->name,
                'credit'    => $uAgreement->credit,
                'balance'   => $uAgreement->balance
            ]);
        }
    }
}
