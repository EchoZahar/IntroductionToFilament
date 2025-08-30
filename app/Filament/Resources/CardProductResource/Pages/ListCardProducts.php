<?php

namespace App\Filament\Resources\CardProductResource\Pages;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\Filter;
use Filament\Resources\Components\Tab;
use Filament\Tables\Columns\TextColumn;
use App\Enum\CardProduct\CardStatusEnum;
use Filament\Tables\Columns\ImageColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Enum\CardProduct\MultiplicityEnum;
use App\Filament\Resources\CardProductResource;

class ListCardProducts extends ListRecords
{
    protected static string $resource = CardProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('all')
                ->label('all')
                ->badge($this->getCardCountByStatus()),
            'new' => Tab::make('new')
                ->label('new')
                ->badge($this->getCardCountByStatus(CardStatusEnum::NEW))
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', '=', CardStatusEnum::NEW);
                }),
            'in_progress' => Tab::make('in_progress')
                ->label('in progress')
                ->badge($this->getCardCountByStatus(CardStatusEnum::IN_PROGRESS))
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', '=', CardStatusEnum::IN_PROGRESS);
                }),
            'ready' => Tab::make('errors')
                ->label('ready')
                ->badge($this->getCardCountByStatus(CardStatusEnum::READY_TO_SEND))
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', '=', CardStatusEnum::READY_TO_SEND);
                }),
            'errors' => Tab::make('mp_errors')
                ->label('errors')
                ->badge($this->getCardCountByStatus(CardStatusEnum::ERRORS))
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', '=', CardStatusEnum::ERRORS);
                }),
            'hidden' => Tab::make('mp_errors')
                ->label('hidden')
                ->badge($this->getCardCountByStatus(CardStatusEnum::HIDDEN))
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', '=', CardStatusEnum::HIDDEN);
                }),
            'archive' => Tab::make('mp_errors')
                ->label('archive')
                ->badge($this->getCardCountByStatus(CardStatusEnum::ARCHIVE))
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', '=', CardStatusEnum::ARCHIVE);
                }),
        ];
    }

    public function table(Table $table): Table
    {
        return $table->columns([
                ImageColumn::make('preview')
                    ->label('превью')
                    ->getStateUsing(function ($record) {
                        return $record->getFirstMediaUrl('preview');
                    })
                    ->circular()
                    ->toggleable(),
                TextColumn::make('category.name')
                    ->numeric(),
                TextColumn::make('name')
                    ->limit(100, '...')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('brand'),
                TextColumn::make('article')
                    ->searchable(isIndividual: true),
                TextColumn::make('unique_key')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('barcode'),
                TextColumn::make('multiplicity')->badge(),
                TextColumn::make('multiplicity_sale')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')->badge(),
                TextColumn::make('expiration_date')
                    ->numeric(),
                TextColumn::make('tnved'),
                TextColumn::make('okpd2'),
                TextColumn::make('combine'),
                TextColumn::make('group'),
                TextColumn::make('editor.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('tnved')
                    ->query(fn (Builder $query) => $query->whereNotNull('tnved')),
                SelectFilter::make('multiplicity')
                    ->options(MultiplicityEnum::class),
                SelectFilter::make('status')
                    ->options(CardStatusEnum::class),
                SelectFilter::make('brand')
                    ->options(DB::table('card_products')->pluck('brand', 'brand')->unique()->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc')
            ->paginated([5, 25, 100]);
    }

    private function getCardCountByStatus(CardStatusEnum ...$enum): int
    {
        if ($enum) {
            return DB::table('card_products')
                ->where('status', '=', $enum)
                ->count();
        } else {
            return DB::table('card_products')->count();
        }
    }
}
