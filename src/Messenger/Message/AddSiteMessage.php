<?php

namespace App\Messenger\Message;

class AddSiteMessage
{
    public function __construct(private int $siteId)
    {
    }

    public function getSiteId(): int {
        return $this->siteId;
    }
}