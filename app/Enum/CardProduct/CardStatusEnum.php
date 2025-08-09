<?php

namespace App\Enum\CardProduct;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum CardStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case NEW                = 'new';
    case IN_PROGRESS        = 'in_progress';
    case READY_TO_SEND      = 'ready_to_send';
    case ERRORS             = 'errors';
    case HIDDEN             = 'hidden';
    case ARCHIVE            = 'archive';

    public function getLabel(): string
    {
        return match ($this) {
            self::NEW               => 'Новые',
            self::IN_PROGRESS       => 'Редактируются',
            self::READY_TO_SEND     => 'Готовые',
            self::ERRORS            => 'С ошибками',
            self::HIDDEN            => 'Скрытые',
            self::ARCHIVE           => 'Архив',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NEW           => 'gray',
            self::IN_PROGRESS   => 'warning',
            self::READY_TO_SEND => 'success',
            self::ERRORS        => 'warning',
            self::HIDDEN        => 'warning',
            self::ARCHIVE       => 'warning'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::NEW           => 'heroicon-m-pencil',
            self::IN_PROGRESS   => 'heroicon-m-eye',
            self::READY_TO_SEND => 'heroicon-m-check',
            self::ERRORS        => 'heroicon-m-eye',
            self::HIDDEN        => 'heroicon-m-eye',
            self::ARCHIVE       => 'heroicon-m-eye',
        };
    }
}
