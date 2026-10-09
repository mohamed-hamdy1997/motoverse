<?php

namespace App\Enums\Concerns;

/**
 * Exposes a backed enum as a list of select options for the frontend.
 */
trait HasOptions
{
    abstract public function label(): string;

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function options(): array
    {
        return array_map(
            fn (self $case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases(),
        );
    }
}
