<?php

namespace App\Filament\Resources\MarketResource\Pages;

use Filament\Forms;
use Filament\Actions;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MarketResource;
use App\Filament\Resources\MarketResource\RelationManagers\PortalAgreementsRelationManager;

class EditMarket extends EditRecord
{
    protected static string $resource = MarketResource::class;

    public static function getRelations(): array
    {
        return [
            PortalAgreementsRelationManager::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('marketplace_id')
                    ->relationship('marketplace', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->live()
                    ->afterStateUpdated(function (Set $set, string $state) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->disabledOn('edit')
                    ->required(),
                TextInput::make('portal_hash')
                    ->label('Portal hash')
                    ->maxLength(120),
                KeyValue::make('credentials')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                KeyValue::make('contacts'),
            ])->columns(1);
    }
}
