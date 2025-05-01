<?php

namespace App\Enum\Stock;

enum StockRequestStatus: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Fulfilled = 'fulfilled';
}