<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('add-accessory-to-carte')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('add-accessory-to-carte')]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale:10 )]
    #[Groups('add-accessory-to-carte')]
    private ?string $price = null;

    #[ORM\Column]
    #[Groups('add-accessory-to-carte')]
    private ?bool $available = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Params::class, inversedBy: 'items')]
    private Collection $params;

    #[ORM\ManyToOne(inversedBy: 'items', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Attributes $attributes = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('add-accessory-to-carte')]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'items')]
    private Collection $orders;

    public function __construct()
    {
        $this->params = new ArrayCollection();
        $this->orders = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static
    {
        $this->available = $available;

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
     * @return Collection<int, Params>
     */
    public function getParams(): Collection
    {
        return $this->params;
    }

    public function addParam(Params $param): static
    {
        if (!$this->params->contains($param)) {
            $this->params->add($param);
        }

        return $this;
    }

    public function removeParam(Params $param): static
    {
        $this->params->removeElement($param);

        return $this;
    }

    public function getAttributes(): ?Attributes
    {
        return $this->attributes;
    }

    public function setAttributes(?Attributes $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addItem($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeItem($this);
        }

        return $this;
    }
}
