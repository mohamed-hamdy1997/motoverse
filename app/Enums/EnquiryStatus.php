<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum EnquiryStatus: string
{
    use HasOptions;

    case New = 'new';
    case Contacted = 'contacted';
    case Closed = 'closed';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
