<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum EnquiryType: string
{
    use HasOptions;

    case TestRide = 'test_ride';
    case Sales = 'sales';
    case Finance = 'finance';
    case Service = 'service';

    public function label(): string
    {
        return match ($this) {
            self::TestRide => 'Test Ride',
            self::Sales => 'Sales Enquiry',
            self::Finance => 'Financing',
            self::Service => 'Service Booking',
        };
    }
}
