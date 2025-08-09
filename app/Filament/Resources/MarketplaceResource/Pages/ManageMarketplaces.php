<?php

namespace App\Filament\Resources\MarketplaceResource\Pages;

use App\Filament\Resources\MarketplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMarketplaces extends ManageRecords
{
    protected static string $resource = MarketplaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
