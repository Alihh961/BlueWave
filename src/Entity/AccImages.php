<?php

namespace App\Entity;

use App\Repository\AccImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccImagesRepository::class)]
class AccImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'accImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Accessories $accessory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getAccessory(): ?Accessories
    {
        return $this->accessory;
    }

    public function setAccessory(?Accessories $accessory): static
    {
        $this->accessory = $accessory;

        return $this;
    }
}
