<?php

namespace App\Entity;

use App\Repository\InformationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InformationRepository::class)]
class Information
{
    #[ORM\Id]
    #[ORM\GeneratedValue("CUSTOM")]
    #[Assert\Uuid]
    #[ORM\Column(type:"uuid", unique:true)]
    #[ORM\CustomIdGenerator("doctrine.uuid_generator")]
    private ?string $id = null;

    #[ORM\Column(length: 13)]
    private ?string $corp_phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 100)]
    private ?string $city = null;

    #[ORM\Column(length: 180)]
    private ?string $corp_email = null;

    #[ORM\Column]
    private ?bool $active = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCorpPhone(): ?string
    {
        return $this->corp_phone;
    }

    public function setCorpPhone(string $corp_phone): self
    {
        $this->corp_phone = $corp_phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCorpEmail(): ?string
    {
        return $this->corp_email;
    }

    public function setCorpEmail(string $corp_email): self
    {
        $this->corp_email = $corp_email;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
