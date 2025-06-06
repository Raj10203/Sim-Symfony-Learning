<?php

namespace App\Enum;

enum StockRequestItemsStatus: int
{
    case Rejected = 0;
    case Pending = 1;
    case Approved = 2;
    case Fulfilled = 3;
    public function badge(): string
    {
        return match ($this) {
            self::Pending   => '<span class="badge rounded-pill text-bg-warning">Pending</span>',
            self::Approved  => '<span class="badge rounded-pill text-bg-success">Approved</span>',
            self::Rejected  => '<span class="badge rounded-pill text-bg-danger">Rejected</span>',
            self::Fulfilled => '<span class="badge rounded-pill text-bg-info">Fulfilled</span>',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Pending   => 'Pending',
            self::Approved  => 'Approved',
            self::Rejected  => 'Rejected',
            self::Fulfilled => 'Fulfilled',
        };
    }
}