<?php

namespace App\Filament\Resources\CardProductResource\Pages;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CardProductResource;
use App\Models\ChCategory;
use Filament\Forms\Components\Select;

class EditCardProduct extends EditRecord
{
    protected static string $resource = CardProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('portal_nomenclature_id')
                    ->numeric()
                    ->readOnly(),
                Select::make('ch_category_id')
                    ->options(ChCategory::pluck('name', 'id')),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('description')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'h2',
                        'h3',
                        'italic',
                        'orderedList',
                        'redo',
                        'underline',
                    ]),
                TextInput::make('brand')
                    ->required()
                    ->maxLength(200),
                TextInput::make('article')
                    ->required()
                    ->maxLength(200),
                TextInput::make('unique_key')
                    ->required()
                    ->maxLength(200),
                TextInput::make('barcode')
                    ->maxLength(255),
                TextInput::make('multiplicity')
                    ->required()
                    ->maxLength(10)
                    ->default('one'),
                TextInput::make('multiplicity_sale')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('status')
                    ->required()
                    ->maxLength(100)
                    ->readOnly(),
                TextInput::make('expiration_date')
                    ->label('expiration date (enter days)')
                    ->numeric(),
                TextInput::make('tnved')
                    ->readOnly(),
                TextInput::make('okpd2')
                    ->readOnly(),
                TextInput::make('combine')
                    ->maxLength(255),
                TextInput::make('group')
                    ->maxLength(255),
                // TextInput::make('errors_or_exceptions'),
                TextInput::make('creator.name')
                    ->label('creator')
                    ->readOnly(),
                TextInput::make('editor.name')
                    ->label('editor')
                    ->readOnly(),
            ]);
    }
}
