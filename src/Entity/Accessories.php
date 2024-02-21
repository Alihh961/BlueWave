<?php

namespace App\Entity;

use App\Repository\AccessoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessoriesRepository::class)]
class Accessories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'accessories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AccCategory $accCategory = null;

    #[ORM\OneToMany(mappedBy: 'accessory', targetEntity: AccImages::class)]
    private Collection $accImages;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    public function __construct()
    {
        $this->accImages = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getAccCategory(): ?AccCategory
    {
        return $this->accCategory;
    }

    public function setAccCategory(?AccCategory $accCategory): static
    {
        $this->accCategory = $accCategory;

        return $this;
    }

    /**
     * @return Collection<int, AccImages>
     */
    public function getAccImages(): Collection
    {
        return $this->accImages;
    }

    public function addAccImage(AccImages $accImage): static
    {
        if (!$this->accImages->contains($accImage)) {
            $this->accImages->add($accImage);
            $accImage->setAccessory($this);
        }

        return $this;
    }

    public function removeAccImage(AccImages $accImage): static
    {
        if ($this->accImages->removeElement($accImage)) {
            // set the owning side to null (unless already changed)
            if ($accImage->getAccessory() === $this) {
                $accImage->setAccessory(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
