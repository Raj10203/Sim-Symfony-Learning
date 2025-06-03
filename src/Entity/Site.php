<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('site')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('site:read')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('site')]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Groups('site:read')]
    private ?string $location = null;

    #[ORM\Column]
    #[Groups('site')]
    private ?bool $active = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'site')]
    #[Groups('user_details')]
    private Collection $users;

    /**
     * @var Collection<int, StockRequest>
     */
    #[ORM\OneToMany(targetEntity: StockRequest::class, mappedBy: 'fromSite')]
    private Collection $stockRequestsFrom;

    /**
     * @var Collection<int, StockRequest>
     */
    #[ORM\OneToMany(targetEntity: StockRequest::class, mappedBy: 'toSite')]
    private Collection $stockRequestsTo;

    /**
     * @var Collection<int, Inventory>
     */
    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'site')]
    private Collection $inventories;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setSite($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSite() === $this) {
                $user->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StockRequest>
     */
    public function getStockRequestsFrom(): Collection
    {
        return $this->stockRequestsFrom;
    }

    public function addStockRequestsFrom(StockRequest $stockRequestsFrom): static
    {
        if (!$this->stockRequestsFrom->contains($stockRequestsFrom)) {
            $this->stockRequestsFrom->add($stockRequestsFrom);
            $stockRequestsFrom->setFromSite($this);
        }

        return $this;
    }

    public function removeStockRequestsFrom(StockRequest $stockRequestsFrom): static
    {
        if ($this->stockRequestsFrom->removeElement($stockRequestsFrom)) {
            // set the owning side to null (unless already changed)
            if ($stockRequestsFrom->getFromSite() === $this) {
                $stockRequestsFrom->setFromSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StockRequest>
     */
    public function getStockRequestsTo(): Collection
    {
        return $this->stockRequestsTo;
    }

    public function addStockRequestsTo(StockRequest $stockRequestsTo): static
    {
        if (!$this->stockRequestsTo->contains($stockRequestsTo)) {
            $this->stockRequestsTo->add($stockRequestsTo);
            $stockRequestsTo->setToSite($this);
        }

        return $this;
    }

    public function removeStockRequestsTo(StockRequest $stockRequestsTo): static
    {
        if ($this->stockRequestsTo->removeElement($stockRequestsTo)) {
            // set the owning side to null (unless already changed)
            if ($stockRequestsTo->getToSite() === $this) {
                $stockRequestsTo->setToSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Inventory>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): static
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories->add($inventory);
            $inventory->setSite($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): static
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getSite() === $this) {
                $inventory->setSite(null);
            }
        }

        return $this;
    }
}
