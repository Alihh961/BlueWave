<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: OrderStatusHistory::class)]
    private Collection $orderStatusHistory;

    public function __construct()
    {
        $this->orderStatusHistory = new ArrayCollection();
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
     * @return Collection<int, OrderStatusHistory>
     */
    public function getOrderStatusHistory(): Collection
    {
        return $this->orderStatusHistory;
    }

    public function addOrderStatusHistory(OrderStatusHistory $orderStatusHistory): static
    {
        if (!$this->orderStatusHistory->contains($orderStatusHistory)) {
            $this->orderStatusHistory->add($orderStatusHistory);
            $orderStatusHistory->setStatus($this);
        }

        return $this;
    }

    public function removeOrderStatusHistory(OrderStatusHistory $orderStatusHistory): static
    {
        if ($this->orderStatusHistory->removeElement($orderStatusHistory)) {
            // set the owning side to null (unless already changed)
            if ($orderStatusHistory->getStatus() === $this) {
                $orderStatusHistory->setStatus(null);
            }
        }

        return $this;
    }
}
