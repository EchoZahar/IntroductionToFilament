<?php

namespace App\Filament\Resources\ChCategoryResource\RelationManagers;

use App\Models\ChPortalCategory;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortalCategoryRelationManager extends RelationManager
{
    protected static string $relationship = 'portalCategory';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('change')
                    ->label('change portal relation category')
                    ->form([
                        Select::make('change')
                            ->label('choose new category')
                            ->searchable()
                            ->options(ChPortalCategory::query()->pluck('name', 'id')->toArray())
                            ->required(),
                    ])
                    ->requiresConfirmation()
                    ->action(function (array $data) {
                        $portalCategory = ChPortalCategory::query()->firstWhere('id', '=', $data['change']);
                        if ($portalCategory) {
                            $this->ownerRecord->portalCategory->detach();
                            $portalCategory->update(['ch_category_id' => $this->ownerRecord->id]);
                        }
                    }),
            ]);
    }
}
