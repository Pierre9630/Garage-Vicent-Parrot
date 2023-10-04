<?php

namespace App\Entity;

use App\Repository\OffersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OffersRepository::class)]
#[UniqueEntity(fields: ['reference'])]
class Offers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\Unique(message="La valeur {{ value }}  est déjà dans la base.")
     */
    #[ORM\Column(length: 100)]
    private ?string $reference = null;

    #[ORM\Column(length: 100)]
    private ?string $offer_title = null;

    /*#[ORM\OneToOne(inversedBy: 'offer', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cars $car = null;*/

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: Images::class, orphanRemoval: true,cascade: ["persist", "remove"])]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: Contacts::class, orphanRemoval: true)]
    private Collection $contacts;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modified_at = null;

    #[ORM\JoinColumn]
    #[ORM\OneToOne(cascade: ['persist'])]
    private ?Cars $car = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getOfferTitle(): ?string
    {
        return $this->offer_title;
    }

    public function setOfferTitle(string $offer_title): self
    {
        $this->offer_title = $offer_title;

        return $this;
    }

    /*public function getCarId(): ?Cars
    {
        return $this->car;
    }

    public function setCarId(Cars $car): self
    {
        $this->car = $car;

        return $this;
    }*/

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
            $image->setOffer($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getOffer() === $this) {
                $image->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contacts>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contacts $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setOffer($this);
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getOffer() === $this) {
                $contact->setOffer(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(?\DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getCar(): ?Cars
    {
        return $this->car;
    }

    public function setCar(?Cars $car): self
    {
        $this->car = $car;

        return $this;
    }
}
