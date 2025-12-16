<?php

declare(strict_types=1);

namespace App\Enums;

enum Language: string
{
    case ENGLISH = 'en';
    case KURDISH = 'ku';

    /**
     * Get all language values
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $lang) => $lang->value, self::cases());
    }

    /**
     * Get language label for display
     */
    public function label(): string
    {
        return match ($this) {
            self::ENGLISH => 'English',
            self::KURDISH => 'کوردی',
        };
    }

    /**
     * Check if language is RTL
     */
    public function isRtl(): bool
    {
        return $this === self::KURDISH;
    }

    /**
     * Get text direction
     */
    public function direction(): string
    {
        return $this->isRtl() ? 'rtl' : 'ltr';
    }
}


