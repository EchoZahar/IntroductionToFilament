<?php

namespace App\Filament\Resources\MarketResource\RelationManagers;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;

class PortalDeliveryAddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'portalDeliveryAddresses';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('uda_id')
            ->columns([
                TextColumn::make('uda_id'),
                TextColumn::make('address'),
                TextColumn::make('updated_at')->dateTime('d.m.Y'),
            ])
            ->filters([
                //
            ])->paginated(false);
    }
}
