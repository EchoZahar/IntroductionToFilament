<?php

namespace App\Filament\Resources\CardProductResource\Pages;

use App\Models\Media;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\ChCategory;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\CardProductResource;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditCardProduct extends EditRecord
{
    protected static string $resource = CardProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('card info')->schema([
                        Select::make('ch_category_id')
                            ->options(ChCategory::pluck('name', 'id'))
                            ->searchable(),
                        TextInput::make('portal_nomenclature_id')
                            ->numeric()
                            ->readOnly()
                            ->columns(1),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                            TextInput::make('brand')
                            ->required()
                            ->maxLength(200)
                            ->readOnly(),
                        TextInput::make('article')
                            ->required()
                            ->maxLength(200)
                            ->readOnly(),
                        TextInput::make('unique_key')
                            ->required()
                            ->maxLength(200)
                            ->readOnly(),
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
                            ])
                            ->nullable(),
                    ])->columns(2),
                    Tab::make('media')->schema([
                        Grid::make(5)->schema([
                            Grid::make(1)->schema([
                                SpatieMediaLibraryFileUpload::make('preview')
                                    ->label('preview')
                                    ->collection('preview')
                                    ->image()
                                    ->imageEditor()
                                    ->mediaName(fn (Get $get): string => $get('article') . '_1')
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) use ($form): string {
                                        return $form->model->article . '_1.' . $file->guessExtension();
                                    })
                                    ->disk('media'),
                            ])
                            ->columnSpan(1),
                            Grid::make(1)->schema([
                                SpatieMediaLibraryFileUpload::make('images')
                                    ->label('images collection')
                                    ->imageEditor()
                                    ->collection('collection')
                                    ->multiple()
                                    ->image()
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) use ($form) {
                                        $count = Media::query()
                                            ->where('model_type', '=', 'App\Models\CardProduct')
                                            ->where('model_id', '=', $form->model->id)
                                            ->count();
                                        return $form->model->article . '_' . $count + 1 . '.' . $file->guessExtension();
                                    })
                                    ->disk('media')
                                    ->reorderable()
                                    ->panelLayout('grid')
                            ])
                            ->columnSpan(4),
                        ]),
                    ]),
                ])
            ])
            ->columns('full');
    }
}
