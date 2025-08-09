<?php

namespace App\Contracts\PortalData;

interface TypesContract
{
    public function handle(int $marketID, array $types): void;
}
