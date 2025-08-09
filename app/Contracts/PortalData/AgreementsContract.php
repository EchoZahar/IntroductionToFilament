<?php

namespace App\Contracts\PortalData;

interface AgreementsContract
{
    public function handle(int $marketID, array $agreements): void;
}


