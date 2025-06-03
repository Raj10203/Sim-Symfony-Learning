<?php

namespace App\Entity;

use App\Repository\StockMovementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: StockMovementRepository::class)]
class StockMovement
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stockMovements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StockRequest $stockRequest = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarks = null;

    /**
     * @var Collection<int, StockMovementItem>
     */
    #[ORM\OneToMany(targetEntity: StockMovementItem::class, mappedBy: 'stockMovement')]
    private Collection $stockMovementItems;

    public function __construct()
    {
        $this->stockMovementItems = new ArrayCollection();
    }

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, StockMovementItem>
     */
    public function getStockMovementItems(): Collection
    {
        return $this->stockMovementItems;
    }

    public function addStockMovementItem(StockMovementItem $stockMovementItem): static
    {
        if (!$this->stockMovementItems->contains($stockMovementItem)) {
            $this->stockMovementItems->add($stockMovementItem);
            $stockMovementItem->setStockMovement($this);
        }

        return $this;
    }

    public function removeStockMovementItem(StockMovementItem $stockMovementItem): static
    {
        if ($this->stockMovementItems->removeElement($stockMovementItem)) {
            // set the owning side to null (unless already changed)
            if ($stockMovementItem->getStockMovement() === $this) {
                $stockMovementItem->setStockMovement(null);
            }
        }

        return $this;
    }
}
