<?php

namespace App\Enum\CardProduct;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MultiplicityEnum: string implements HasLabel, HasColor
{
    case ONE = 'one'; // штука

    case SET = 'set'; // комплект

    public function getLabel(): string
    {
        return match ($this) {
            self::ONE   => 'штучно',
            self::SET   => 'комплект'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ONE => 'success',
            self::SET => 'warning'
        };
    }
}
