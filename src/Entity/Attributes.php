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

    #[ORM\Column(type: Types::ARRAY , nullable: true)]
    private array $value_ = [];

    #[ORM\OneToMany(mappedBy: 'attributes', targetEntity: VisionItem::class)]
    private Collection $items;

    #[ORM\Column(type: Types::ARRAY , nullable: true)]
    private array $minAndMax = [];

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }




    public function getValue(): array
    {
        return $this->value_;
    }

    public function setValue(array $value_): static
    {
        $this->value_ = $value_;

        return $this;
    }

    /**
     * @return Collection<int, VisionItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(VisionItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setAttributes($this);
        }

        return $this;
    }

    public function removeItem(VisionItem $item): static
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


}
