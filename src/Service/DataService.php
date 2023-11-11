<?php

// src/Service/DataService.php

namespace App\Service;

use App\Repository\OpeningHourRepository;
use App\Repository\InformationRepository;

class DataService
{
    private $openingHourRepository;
    private $informationRepository;

    public function __construct(OpeningHourRepository $openingHourRepository, InformationRepository $informationRepository)
    {
        $this->openingHourRepository = $openingHourRepository;
        $this->informationRepository = $informationRepository;
    }

    public function getOpeningHours()
    {
        return $this->openingHourRepository->findAll();
    }

    public function getActiveInformation()
    {
        return $this->informationRepository->findActiveInformation();
    }
}
