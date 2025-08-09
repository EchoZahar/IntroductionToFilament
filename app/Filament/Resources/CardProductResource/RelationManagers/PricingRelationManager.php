<?php

namespace App\Filament\Resources\CardProductResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PricingRelationManager extends RelationManager
{
    protected static string $relationship = 'pricing';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vat')
                    ->required()
                    ->options([
                        '0.2' => '20%',
                        '0.1' => '10%',
                        '0.0' => '0%'
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cost_price')
                    ->numeric(),
                TextColumn::make('market_price')
                    ->numeric(),
                TextColumn::make('vip_three')
                    ->numeric(),
                TextColumn::make('three_price')
                    ->numeric(),
                TextColumn::make('original_price')
                    ->numeric(),
                TextColumn::make('currency_code'),
                TextColumn::make('vat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ]);
    }
}
