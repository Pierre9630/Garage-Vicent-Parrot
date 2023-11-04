<?php

namespace App\Controller;

use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchAPI extends AbstractController
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    #[Route('/searchAPI', name: 'app_searchapi_index', methods: ['GET','POST'])]
    public function index(Request $request):JsonResponse
    {
        $keyword = $request->query->get('keyword');
        $brand = $request->query->get('brand');
        $minPrice = $request->query->get('minPrice',0);
        $maxPrice = $request->query->get('maxPrice',100000);
        $minKilometers = $request->query->get('minKilometers',0);
        $maxKilometers = $request->query->get('maxKilometers',1000000);
        $reference = $request->query->get('reference');

        if ($minPrice !== null) {
            // Convertir la chaîne en un entier
            $minPrice = (int) $minPrice;
        }

        if ($maxPrice !== null) {
            // Convertir la chaîne en un entier
            $maxPrice = (int) $maxPrice;
        }
        if ($minKilometers !== null) {
            // Convertir la chaîne en un entier
            $minKilometers = (int) $minKilometers;
        }
        if ($maxKilometers !== null) {
            // Convertir la chaîne en un entier
            $maxKilometers = (int) $maxKilometers;
        }
        $test = [
            "test" => "banana",
            "titi" => "toto"
        ];
        $searchResults = $this->searchService->searchWithFilters($keyword, $brand, $minPrice, $maxPrice, $minKilometers, $maxKilometers,$reference);
        //dd(json_encode());

        return new JsonResponse(json_encode($test),200,[],true);
    }
}