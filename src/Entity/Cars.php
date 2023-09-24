<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarsRepository::class)]
class Cars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $brand = null;

    #[ORM\Column(length: 100)]
    private ?string $model = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?int $kilometers = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'cars_id', targetEntity: Images::class, orphanRemoval: true,cascade: ["persist", "remove"])]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'cars_id', targetEntity: Contact::class)]
    private Collection $contact_id;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->contact_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getKilometers(): ?int
    {
        return $this->kilometers;
    }

    public function setKilometers(int $kilometers): self
    {
        $this->kilometers = $kilometers;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCarsId($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCarsId() === $this) {
                $image->setCarsId(null);
            }
        }

        return $this;
    }
    public function __toString() : string
    {
        return $this->brand;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContactId(): Collection
    {
        return $this->contact_id;
    }

    public function addContactId(Contact $contactId): static
    {
        if (!$this->contact_id->contains($contactId)) {
            $this->contact_id->add($contactId);
            $contactId->setCarsId($this);
        }

        return $this;
    }

    public function removeContactId(Contact $contactId): static
    {
        if ($this->contact_id->removeElement($contactId)) {
            // set the owning side to null (unless already changed)
            if ($contactId->getCarsId() === $this) {
                $contactId->setCarsId(null);
            }
        }

        return $this;
    }
}
