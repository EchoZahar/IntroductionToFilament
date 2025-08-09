<?php

namespace App\Filament\Resources\ChCategoryResource\Pages;

use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ChCategoryResource;

class EditChCategory extends EditRecord
{
    protected static string $resource = ChCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
                TextInput::make('name'),
                TextInput::make('level'),
                Toggle::make('is_active_on_ch'),
                Toggle::make('is_visible'),
            ])
            ->columns(1);
    }
}
