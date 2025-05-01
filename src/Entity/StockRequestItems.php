<?php

namespace App\Entity;

use App\Enum\Stock\StockRequestStatus;
use App\Repository\StockRequestItemsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: StockRequestItemsRepository::class)]
class StockRequestItems
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stockRequestItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StockRequest $stockRequest = null;

    #[ORM\ManyToOne(inversedBy: 'stockRequestItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Products $product = null;

    #[ORM\Column]
    private ?int $quantity_requested = null;

    #[ORM\Column]
    private ?int $quantity_approved = 0;

    #[ORM\Column(type: 'string', enumType: StockRequestStatus::class, name: 'status')]
    private StockRequestStatus $status = StockRequestStatus::Pending;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestId(): ?StockRequest
    {
        return $this->stockRequest;
    }

    public function setRequestId(?StockRequest $stockRequest): static
    {
        $this->stockRequest = $stockRequest;

        return $this;
    }

    public function getProductId(): ?Products
    {
        return $this->product;
    }

    public function setProductId(?Products $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantityRequested(): ?int
    {
        return $this->quantity_requested;
    }

    public function setQuantityRequested(int $quantity_requested): static
    {
        $this->quantity_requested = $quantity_requested;

        return $this;
    }

    public function getQuantityApproved(): ?int
    {
        return $this->quantity_approved;
    }

    public function setQuantityApproved(int $quantity_approved): static
    {
        $this->quantity_approved = $quantity_approved;

        return $this;
    }

    public function getStatus(): StockRequestStatus
    {
        return $this->status;
    }

    public function setStatus(StockRequestStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}
