<?php

// src/Service/DataService.php

namespace App\Service;

use App\Entity\Information;
use App\Repository\OpeningHourRepository;
use App\Repository\InformationRepository;

class DataService
{

    public function __construct(private readonly OpeningHourRepository $openingHourRepository,
                                private readonly InformationRepository $informationRepository)
    {

    }

    public function getOpeningHours(): array
    {
        return $this->openingHourRepository->findAll();
    }

    public function getActiveInformation(): ?Information
    {
        return $this->informationRepository->findActiveInformation();
    }
}
