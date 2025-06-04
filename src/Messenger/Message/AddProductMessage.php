<?php

namespace App\Messenger\Message;

use App\Entity\Product;

class AddProductMessage
{
    public function __construct(private int $productid)
    {
    }

    public function getProductId(): int {
        return $this->productid;
    }
}