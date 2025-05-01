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
    private ?int $quantityRequested = null;

    #[ORM\Column]
    private ?int $quantityApproved = 0;

    #[ORM\Column(type: 'string', enumType: StockRequestStatus::class, name: 'status')]
    private StockRequestStatus $status = StockRequestStatus::Pending;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockRequest(): ?StockRequest
    {
        return $this->stockRequest;
    }

        public function setstockRequest(?StockRequest $stockRequest): static
    {
        $this->stockRequest = $stockRequest;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantityRequested(): ?int
    {
        return $this->quantityRequested;
    }

    public function setQuantityRequested(int $quantityRequested): static
    {
        $this->quantityRequested = $quantityRequested;

        return $this;
    }

    public function getQuantityApproved(): ?int
    {
        return $this->quantityApproved;
    }

    public function setQuantityApproved(int $quantityApproved): static
    {
        $this->quantityApproved = $quantityApproved;

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
