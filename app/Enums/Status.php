<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum Status: string implements HasLabel, HasColor, HasIcon
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case APPROVED = 'approved';
    case DRAFT = 'draft';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::REJECTED => 'Rejected',
            self::APPROVED => 'Approved',
            self::DRAFT => 'Draft',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::REJECTED => 'danger',
            self::APPROVED => 'success',
            self::DRAFT => 'Draft',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENDING => 'heroicon-m-pencil',
            self::REJECTED => 'heroicon-o-x-mark',
            self::APPROVED => 'heroicon-m-check',
            self::DRAFT => 'heroicon-o-document-duplicate',
        };
    }

}