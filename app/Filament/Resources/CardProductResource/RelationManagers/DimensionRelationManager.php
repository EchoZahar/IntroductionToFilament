<?php

namespace App\Filament\Resources\CardProductResource\RelationManagers;

use App\Services\CardProduct\Dimension\DimensionDataService;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DimensionRelationManager extends RelationManager
{
    protected static string $relationship = 'dimension';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('length')->required()->numeric(),
                TextInput::make('width')->required()->numeric(),
                TextInput::make('height')->required()->numeric(),
                TextInput::make('net_weight')->required()->numeric(),
                TextInput::make('gross_weight')->required()->numeric(),
            ])
            ->columns('full');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('length')->numeric(),
                TextColumn::make('width')->numeric(),
                TextColumn::make('height')->numeric(),
                TextColumn::make('dimension_unit'),
                TextColumn::make('net_weight')->numeric(),
                TextColumn::make('gross_weight')->numeric(),
                TextColumn::make('weight_unit'),
                TextColumn::make('volume')->numeric(),
                TextColumn::make('volume_liter')->numeric(),
                TextColumn::make('volume_weight')->numeric(),
                ToggleColumn::make('is_kgt')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (array $data, $record): void {
                        $user = Auth::user();
                        app(DimensionDataService::class)->processData($data, $record, $user);
                    }),
            ]);
    }
}
