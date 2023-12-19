<?php

namespace App\Entity;

use App\Repository\OrderStatusHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderStatusHistoryRepository::class)]
class OrderStatusHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $statusUpdateDate = null;


    #[ORM\ManyToOne(inversedBy: 'orderStatusHistory')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'orderStatusHistory')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $_order = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusUpdateDate(): ?\DateTimeInterface
    {
        return $this->statusUpdateDate;
    }

    public function setStatusUpdateDate(\DateTimeInterface $statusUpdateDate): static
    {
        $this->statusUpdateDate = $statusUpdateDate;

        return $this;
    }


    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->_order;
    }

    public function setOrder(?Order $_order): static
    {
        $this->_order = $_order;

        return $this;
    }
}
