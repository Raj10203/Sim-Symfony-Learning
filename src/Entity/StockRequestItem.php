<?php

namespace App\Entity;

use App\Enum\Stock\StockRequestItemsStatus;
use App\Repository\StockRequestItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: StockRequestItemRepository::class)]
class StockRequestItem
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
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $quantityRequested = null;

    #[ORM\Column]
    private ?int $quantityApproved = 0;

    #[ORM\Column(name: 'status', type: 'string', enumType: StockRequestItemsStatus::class)]
    private StockRequestItemsStatus $status = StockRequestItemsStatus::Pending;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockRequest(): ?StockRequest
    {
        return $this->stockRequest;
    }

        public function setStockRequest(?StockRequest $stockRequest): static
    {
        $this->stockRequest = $stockRequest;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
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

    public function getStatus(): StockRequestItemsStatus
    {
        return $this->status;
    }

    public function setStatus(StockRequestItemsStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}
