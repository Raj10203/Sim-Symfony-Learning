<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
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

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, StockRequestItem>
     */
    #[ORM\OneToMany(targetEntity: StockRequestItem::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $stockRequestItems;

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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
            $stockRequestItem->setProduct($this);
        }

        return $this;
    }

    public function removeStockRequestItem(StockRequestItem $stockRequestItem): static
    {
        if ($this->stockRequestItems->removeElement($stockRequestItem)) {
            // set the owning side to null (unless already changed)
            if ($stockRequestItem->getProduct() === $this) {
                $stockRequestItem->setProduct(null);
            }
        }

        return $this;
    }
}
