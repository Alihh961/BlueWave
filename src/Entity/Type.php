<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    // #[ORM\OneToMany(mappedBy: 'type', targetEntity: Category::class)]
    // private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Item::class)]
    private Collection $items;

    public function __construct()
    {
        // $this->categories = new ArrayCollection();
        $this->items = new ArrayCollection();
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
    //  * @return Collection<int, Category>
     */
    // public function getCategories(): Collection
    // {
    //     return $this->categories;
    // }

    // public function addCategory(Category $category): static
    // {
    //     if (!$this->categories->contains($category)) {
    //         $this->categories->add($category);
    //         $category->setType($this);
    //     }

    //     return $this;
    // }

    // public function removeCategory(Category $category): static
    // {
    //     if ($this->categories->removeElement($category)) {
    //         // set the owning side to null (unless already changed)
    //         if ($category->getType() === $this) {
    //             $category->setType(null);
    //         }
    //     }

    //     return $this;
    // }

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
            $item->setType($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getType() === $this) {
                $item->setType(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
