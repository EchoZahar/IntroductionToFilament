<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardProductResource\Pages;
use App\Filament\Resources\CardProductResource\RelationManagers\DimensionRelationManager;
use App\Filament\Resources\CardProductResource\RelationManagers\PricingRelationManager;
use App\Models\CardProduct;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CardProductResource extends Resource
{
    protected static ?string $model = CardProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getRelations(): array
    {
        return [
            DimensionRelationManager::class,
            PricingRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCardProducts::route('/'),
            'create' => Pages\CreateCardProduct::route('/create'),
            'edit'   => Pages\EditCardProduct::route('/{record}/edit'),
        ];
    }
}
