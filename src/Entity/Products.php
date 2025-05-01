<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $category = null;

    /**
     * @var Collection<int, StockRequestItems>
     */
    #[ORM\OneToMany(targetEntity: StockRequestItems::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $stockRequestItems;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Kolkata'));
        $this->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Kolkata'));
        $this->stockRequestItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, StockRequestItems>
     */
    public function getStockRequestItems(): Collection
    {
        return $this->stockRequestItems;
    }

    public function addStockRequestItem(StockRequestItems $stockRequestItem): static
    {
        if (!$this->stockRequestItems->contains($stockRequestItem)) {
            $this->stockRequestItems->add($stockRequestItem);
            $stockRequestItem->setProductId($this);
        }

        return $this;
    }

    public function removeStockRequestItem(StockRequestItems $stockRequestItem): static
    {
        if ($this->stockRequestItems->removeElement($stockRequestItem)) {
            // set the owning side to null (unless already changed)
            if ($stockRequestItem->getProductId() === $this) {
                $stockRequestItem->setProductId(null);
            }
        }

        return $this;
    }
}
