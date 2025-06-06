<?php

namespace App\Entity;

use App\Repository\StockRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: StockRequestRepository::class)]
class StockRequest
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stockRequestsFrom')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Site $fromSite = null;

    #[ORM\ManyToOne(inversedBy: 'stockRequestsTo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Site $toSite = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $requestedBy = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $approvedBy = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $status = 'draft';

    /**
     * @var Collection<int, StockRequestItem>
     */
    #[ORM\OneToMany(targetEntity: StockRequestItem::class, mappedBy: 'stockRequest', orphanRemoval: true)]
    private Collection $stockRequestItems;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarks = null;

    /**
     * @var Collection<int, StockMovement>
     */
    #[ORM\OneToMany(targetEntity: StockMovement::class, mappedBy: 'stockRequest')]
    private Collection $stockMovements;

    public function __construct()
    {
        $this->stockRequestItems = new ArrayCollection();
        $this->stockMovements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromSite(): ?Site
    {
        return $this->fromSite;
    }

    public function setFromSite(?Site $fromSite): static
    {
        $this->fromSite = $fromSite;

        return $this;
    }

    public function getToSite(): ?Site
    {
        return $this->toSite;
    }

    public function setToSite(?Site $toSite): static
    {
        $this->toSite = $toSite;

        return $this;
    }

    public function getRequestedBy(): ?User
    {
        return $this->requestedBy;
    }

    public function setRequestedBy(?User $requestedBy): static
    {
        $this->requestedBy = $requestedBy;

        return $this;
    }

    public function getApprovedBy(): ?User
    {
        return $this->approvedBy;
    }

    public function setApprovedBy(?User $approvedBy): static
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Collection<int, StockRequestItem>
     */
    public function getStockRequestItems(): Collection
    {
        return $this->stockRequestItems;
    }

    public function addStockRequestItem(StockRequestItem $stockRequestItem): static
    {
        if (!$this->stockRequestItems->contains($stockRequestItem)) {
            $this->stockRequestItems->add($stockRequestItem);
            $stockRequestItem->setStockRequest($this);
        }

        return $this;
    }

    public function removeStockRequestItem(StockRequestItem $stockRequestItem): static
    {
        if ($this->stockRequestItems->removeElement($stockRequestItem)) {
            if ($stockRequestItem->getstockRequest() === $this) {
                $stockRequestItem->setStockRequest(null);
            }
        }
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
     * @return Collection<int, StockMovement>
     */
    public function getStockMovements(): Collection
    {
        return $this->stockMovements;
    }

    public function addStockMovement(StockMovement $stockMovement): static
    {
        if (!$this->stockMovements->contains($stockMovement)) {
            $this->stockMovements->add($stockMovement);
            $stockMovement->setStockRequest($this);
        }

        return $this;
    }

    public function removeStockMovement(StockMovement $stockMovement): static
    {
        if ($this->stockMovements->removeElement($stockMovement)) {
            // set the owning side to null (unless already changed)
            if ($stockMovement->getStockRequest() === $this) {
                $stockMovement->setStockRequest(null);
            }
        }

        return $this;
    }
}
