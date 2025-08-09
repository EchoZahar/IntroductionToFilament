<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChCategoryResource\Pages;
use App\Filament\Resources\ChCategoryResource\RelationManagers;
use App\Filament\Resources\ChCategoryResource\RelationManagers\PortalCategoryRelationManager;
use App\Models\ChCategory;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChCategoryResource extends Resource
{
    protected static ?string $model = ChCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getRelations(): array
    {
        return [
            //PortalCategoryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChCategories::route('/'),
            'create' => Pages\CreateChCategory::route('/create'),
            'edit' => Pages\EditChCategory::route('/{record}/edit'),
        ];
    }
}
