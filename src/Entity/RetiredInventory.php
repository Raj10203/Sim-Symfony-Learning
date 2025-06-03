<?php

namespace App\Entity;

use App\Repository\RetiredInventoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: RetiredInventoryRepository::class)]
class RetiredInventory
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Site $site = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $retiredAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $retiredBy = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $retirementReason = null;

    #[ORM\Column(length: 50)]
    private ?string $serialNo = null;

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

    public function getRetiredAt(): ?\DateTimeImmutable
    {
        return $this->retiredAt;
    }

    public function setRetiredAt(\DateTimeImmutable $retiredAt): static
    {
        $this->retiredAt = $retiredAt;

        return $this;
    }

    public function getRetiredBy(): ?User
    {
        return $this->retiredBy;
    }

    public function setRetiredBy(?User $retiredBy): static
    {
        $this->retiredBy = $retiredBy;

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

    public function getRetirementReason(): ?string
    {
        return $this->retirementReason;
    }

    public function setRetirementReason(?string $retirementReason): static
    {
        $this->retirementReason = $retirementReason;

        return $this;
    }

    public function getSerialNo(): ?string
    {
        return $this->serialNo;
    }

    public function setSerialNo(string $serialNo): static
    {
        $this->serialNo = $serialNo;

        return $this;
    }
}
