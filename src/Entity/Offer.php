<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;


#[ORM\Entity(repositoryClass: OfferRepository::class)]
//#[UniqueEntity(fields: ['reference'])]
#[UniqueEntity(fields: ['reference'],message: 'Ce titre ou reference existe déjà !')]

#[ApiResource(operations: [new Get(), new GetCollection()])]

#[ApiFilter(SearchFilter::class, properties: ['offer_title' => 'partial', 'reference' => 'exact'])]
#[ApiFilter(RangeFilter::class, properties: ['car.price','car.kilometers','car.year'])]
//#[ApiFilter(SearchFilter::class, properties: ["id"=>"partial"])]


class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue("CUSTOM")]
    #[Assert\Uuid]
    #[ORM\Column(type:"uuid", unique:true)]
    #[ORM\CustomIdGenerator("doctrine.uuid_generator")]

    private ?string $id = null;

    /**
     * @Assert\Unique(message="La valeur {{ value }}  est déjà dans la base.")
     */

    #[ORM\Column(length: 100)]
    private ?string $reference = null;

    #[ORM\Column(length: 100)]
    private ?string $offer_title = null;


    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: Image::class, orphanRemoval: true,cascade: ["persist", "remove"])]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: Contact::class, orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $contacts;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modified_at = null;


    #[ORM\OneToOne(inversedBy : 'offer',cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    #[ORM\Column]
    private ?bool $isExposed = false;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?string
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


    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setOffer($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
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
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setOffer($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
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

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function isIsExposed(): ?bool
    {
        return $this->isExposed;
    }

    public function setIsExposed(bool $isExposed): self
    {
        $this->isExposed = $isExposed;

        return $this;
    }
}
