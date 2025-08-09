<?php

namespace App\Filament\Resources\ChCategoryResource\Pages;

use Filament\Actions;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ChCategoryResource;

class CreateChCategory extends CreateRecord
{
    protected static string $resource = ChCategoryResource::class;

    public function form(Form $form): Form
    {
        return $form->schema([
                TextInput::make('name'),

                Select::make('portal_id')
                    ->label('Select portal category')
                    ->searchable()
                    ->options(DB::table('ch_portal_categories')->pluck('name', 'portal_id')->unique()->toArray()),
                Toggle::make('is_active_on_ch'),
                Toggle::make('is_visible'),
            ])
            ->columns(1);
    }
}
