<?php

namespace App\Filament\Resources\ChCategoryResource\Pages;

use App\Filament\Resources\ChCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ListChCategories extends ListRecords
{
    protected static string $resource = ChCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                ToggleColumn::make('is_active_on_ch'),
                ToggleColumn::make('is_visible'),
                TextColumn::make('portalCategory.name'),
                TextColumn::make('updated_at')
                    ->dateTime('d.m.Y H:m')
                    ->toggleable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->paginated([5, 10, 25, 50, 100]);
    }
}
