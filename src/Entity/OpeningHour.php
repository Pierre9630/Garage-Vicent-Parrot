<?php

namespace App\Entity;

use App\Repository\OpeningHourRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OpeningHourRepository::class)]
/*/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_dayOfWeek", columns={"dayOfWeek"})})
 * @UniqueEntity(fields={"dayOfWeek"}, message="Ce jour de la semaine est déjà utilisé.")
 */
class OpeningHour
{
    #[ORM\Id]
    #[ORM\GeneratedValue("CUSTOM")]
    #[Assert\Uuid]
    #[ORM\Column(type:"uuid", unique:true)]
    #[ORM\CustomIdGenerator("doctrine.uuid_generator")]
    private ?string $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $morningOpen = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $morningClose = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $afternoonOpen = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $afternoonClose = null;

    #[ORM\Column(length: 11, nullable: true)]
    private ?string $dayOfWeek = null;

    #[ORM\Column]
    private ?bool $nullifyMorning = null;

    #[ORM\Column]
    private ?bool $nullifyAfternoon = null;   

    public function __toString()
    {
        return $this->dayOfWeek;
    }
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getMorningOpen(): ?\DateTimeInterface
    {
        return $this->morningOpen;
    }

    public function setMorningOpen(?\DateTimeInterface $morningOpen): static
    {
        $this->morningOpen = $morningOpen;

        return $this;
    }

    public function getMorningClose(): ?\DateTimeInterface
    {
        return $this->morningClose;
    }

    public function setMorningClose(?\DateTimeInterface $morningClose): static
    {
        $this->morningClose = $morningClose;

        return $this;
    }

    public function getAfternoonOpen(): ?\DateTimeInterface
    {
        return $this->afternoonOpen;
    }

    public function setAfternoonOpen(?\DateTimeInterface $afternoonOpen): static
    {
        $this->afternoonOpen = $afternoonOpen;

        return $this;
    }

    public function getAfternoonClose(): ?\DateTimeInterface
    {
        return $this->afternoonClose;
    }

    public function setAfternoonClose(?\DateTimeInterface $afternoonClose): static
    {
        $this->afternoonClose = $afternoonClose;

        return $this;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(?string $dayOfWeek): static
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function isNullifyMorning(): ?bool
    {
        return $this->nullifyMorning;
    }

    public function setNullifyMorning(bool $nullifyMorning): static
    {
        $this->nullifyMorning = $nullifyMorning;

        return $this;
    }

    public function isNullifyAfternoon(): ?bool
    {
        return $this->nullifyAfternoon;
    }

    public function setNullifyAfternoon(bool $nullifyAfternoon): static
    {
        $this->nullifyAfternoon = $nullifyAfternoon;

        return $this;
    }
   
}
