<?php

namespace App\Entity;

use App\Repository\AccCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccCategoryRepository::class)]
class AccCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'accCategory', targetEntity: Accessories::class)]
    private Collection $accessories;

    public function __construct()
    {
        $this->accessories = new ArrayCollection();
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

    /**
     * @return Collection<int, Accessories>
     */
    public function getAccessories(): Collection
    {
        return $this->accessories;
    }

    public function addAccessory(Accessories $accessory): static
    {
        if (!$this->accessories->contains($accessory)) {
            $this->accessories->add($accessory);
            $accessory->setAccCategory($this);
        }

        return $this;
    }

    public function removeAccessory(Accessories $accessory): static
    {
        if ($this->accessories->removeElement($accessory)) {
            // set the owning side to null (unless already changed)
            if ($accessory->getAccCategory() === $this) {
                $accessory->setAccCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
    return $this->name;
    }
}
