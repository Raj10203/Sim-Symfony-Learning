<?php

namespace App\Enum;

enum StockRequestItemsStatus: string
{
    case Pending = '<span class="badge rounded-pill text-bg-warning">Pending</span>';
    case Approved = '<span class="badge rounded-pill text-bg-success">Approved</span>';
    case Rejected = '<span class="badge rounded-pill text-bg-danger">Rejected</span>';
    case Fulfilled = '<span class="badge rounded-pill text-bg-info   ">Fulfilled</span>';
}