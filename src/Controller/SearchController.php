<?php

namespace App\Controller;

use App\Entity\Offers;
use App\Repository\OpeningHoursRepository;
use App\Service\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class SearchController extends AbstractController
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    /*private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }*/
    #[Route('/search', name: 'app_search_index', methods: ['GET','POST'])]
    public function search(Request $request,OpeningHoursRepository $oh,PaginatorInterface $paginator ): Response
    {
        /*$keyword = $request->query->get('keyword', '');
        $minPrice = $request->query->get('minPrice', 0);
        $maxPrice = $request->query->get('maxPrice', 1000000);
        $maxKilometers = $request->query->get('maxKilometers', 100000);*/

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

        $searchResults = $this->searchService->searchWithFilters($keyword, $brand, $minPrice, $maxPrice, $minKilometers, $maxKilometers,$reference);
        $pagination = $paginator->paginate(
            $searchResults, // Les données à paginer
            $request->query->getInt('page', 1), // Le numéro de la page
            3 // Le nombre d'éléments par page
        );

        //dd($searchResults);
        return $this->render('search/index.html.twig', [
            'results' => $pagination,
            'openingHours'=>$oh,
            //'minPrice'=>$minPrice,
            //'maxPrice'=>$maxPrice,
        ]);
    }
    /*public function index(Request $request, #[MapEntity(mapping: ['keyword' => 'offerTitle',
        'minPrice' => 'car.price', 'maxPrice' => 'car.price', 'maxKilometers' => 'car.kilometers'])] Offers $offer): Response
    {
        $keyword = $request->query->get('keyword');
        $minPrice = $request->query->get('minPrice');
        $maxPrice = $request->query->get('maxPrice');
        $maxKilometers = $request->query->get('maxKilometers');

        // Utilisez l'entité $offer pour effectuer la recherche en fonction des filtres
        $searchResults = $this->entityManager->getRepository(Offers::class)
            ->findByFilters($keyword, $minPrice, $maxPrice, $maxKilometers);

        return $this->render('search/index.html.twig', [
            'results' => $searchResults,
        ]);
    }*/

}
