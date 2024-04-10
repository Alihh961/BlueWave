<?php

namespace App\Entity;

use App\Repository\AttributesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributesRepository::class)]
class Attributes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToMany(mappedBy: 'attributes', targetEntity: Item::class)]
    private Collection $items;

    #[ORM\Column(type: Types::ARRAY , nullable: true)]
    private array $minAndMax = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quantityValues = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setAttributes($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getAttributes() === $this) {
                $item->setAttributes(null);
            }
        }

        return $this;
    }

    public function getMinAndMax(): array
    {
        return $this->minAndMax;
    }

    public function setMinAndMax(array $minAndMax): static
    {
        $this->minAndMax = $minAndMax;

        return $this;
    }

    public function getQuantityValues(): ?string
    {
        return $this->quantityValues;
    }

    public function setQuantityValues(?string $quantityValues): static
    {
        $this->quantityValues = $quantityValues;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }


}
