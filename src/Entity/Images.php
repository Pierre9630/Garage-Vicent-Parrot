<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(type: Types::BLOB)]
    /**
     * @Vich\UploadableField(mapping="car_images", fileNameProperty="name")
     */
    private $ImageFile = null;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Cars", inversedBy:"images")]

    #[ORM\JoinColumn(nullable:true)]

    private $cars;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getImageFile()
    {
        return $this->ImageFile;
    }

    public function setImageFile($ImageFile): static
    {
        $this->ImageFile = $ImageFile;

        return $this;
    }

    public function getCars()
    {
        return $this->cars;
    }

    public function setCars($cars): static
    {
        $this->cars = $cars;

        return $this;
    }
}
