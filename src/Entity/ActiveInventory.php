<?php

namespace App\Entity;

use App\Enum\ActiveInventoryStatus;
use App\Repository\ActiveInventoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ActiveInventoryRepository::class)]
class ActiveInventory
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'activeInventories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'activeInventories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Site $site = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $receivedAt = null;

    #[ORM\ManyToOne]
    private ?StockMovement $lastStockMovement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarks = null;

    #[ORM\Column(length: 50, enumType: ActiveInventoryStatus::class)]
    private ActiveInventoryStatus $status = ActiveInventoryStatus::Pending;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): static
    {
        $this->site = $site;

        return $this;
    }

    public function getReceivedAt(): ?\DateTimeImmutable
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(?\DateTimeImmutable $receivedAt): static
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function getLastStockMovement(): ?StockMovement
    {
        return $this->lastStockMovement;
    }

    public function setLastStockMovement(?StockMovement $lastStockMovement): static
    {
        $this->lastStockMovement = $lastStockMovement;

        return $this;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(?string $remarks): static
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function getStatus(): ?ActiveInventoryStatus
    {
        return $this->status;
    }

    public function setStatus(ActiveInventoryStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
