<?php

namespace App\Entity;

use App\Enum\Stock\StockRequestStatus;
use App\Repository\StockRequestRepository;
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
    private ?Sites $fromSite = null;

    #[ORM\ManyToOne(inversedBy: 'stockRequestsTo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sites $toSite = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $requested_by = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $approvedBy = null;

    #[ORM\Column(type: 'string', enumType: StockRequestStatus::class)]
    private StockRequestStatus $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromSite(): ?Sites
    {
        return $this->fromSite;
    }

    public function setFromSite(?Sites $fromSite): static
    {
        $this->fromSite = $fromSite;

        return $this;
    }

    public function getToSite(): ?Sites
    {
        return $this->toSite;
    }

    public function setToSite(?Sites $toSite): static
    {
        $this->toSite = $toSite;

        return $this;
    }

    public function getRequestedBy(): ?User
    {
        return $this->requested_by;
    }

    public function setRequestedBy(?User $requested_by): static
    {
        $this->requested_by = $requested_by;

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
