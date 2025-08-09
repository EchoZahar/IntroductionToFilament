<?php

namespace App\Filament\Resources\MarketResource\RelationManagers;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;

class PortalDeliveryTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'portalDeliveryTypes';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('dt_id')
            ->columns([
                TextColumn::make('dt_id'),
                TextColumn::make('name'),
                TextColumn::make('updated_at')->dateTime('d.m.Y H:i'),
            ])
            ->filters([
                //
            ])
            ->paginated(false);
    }
}
