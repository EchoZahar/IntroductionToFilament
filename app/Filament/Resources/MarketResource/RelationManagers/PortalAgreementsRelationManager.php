<?php

namespace App\Filament\Resources\MarketResource\RelationManagers;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;

class PortalAgreementsRelationManager extends RelationManager
{
    protected static string $relationship = 'portalAgreements';

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('ua_id')
            ->columns([
                TextColumn::make('ua_id'),
                TextColumn::make('name'),
                TextColumn::make('credit'),
                TextColumn::make('balance'),
                TextColumn::make('updated_at')->dateTime('d.m.Y')
            ])
            ->filters([
                //
            ])
            ->paginated(false);
    }
}
