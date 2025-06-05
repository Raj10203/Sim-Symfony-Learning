<?php

namespace App\Messenger\Message;

class AddStockToSiteMessage
{
    public function __construct(
        private int $inventoryId,
        private int $quantity,
    )
    {
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getInventoryId(): int
    {
        return $this->inventoryId;
    }

}