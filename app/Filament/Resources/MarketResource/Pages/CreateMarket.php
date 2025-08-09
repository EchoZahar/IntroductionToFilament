<?php

namespace App\Filament\Resources\MarketResource\Pages;

use App\Filament\Resources\MarketResource;
use Filament\Actions;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateMarket extends CreateRecord
{
    protected static string $resource = MarketResource::class;

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
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(120),
                TextInput::make('portal_hash')
                    ->label('Portal hash')
                    ->maxLength(120),
                KeyValue::make('credentials')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                KeyValue::make('contacts')
                    ->keyLabel('Set key')
                    ->keyPlaceholder('Property key: name, email, phone')
                    ->valueLabel('Set value')
                    ->valuePlaceholder('Property value: name, email, phone')
                    ->required(),
            ])->columns(1);
    }
}
