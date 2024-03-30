<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use App\Service\DataService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class IndexController extends AbstractController
{
    private DataService $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager,Request $req,
        ServiceRepository $sr, TestimonialRepository $tr): Response
    {

        $offers = new Offer();
        $searchType = $this->createForm(OfferType::class,$offers);
        $repository = $entityManager->getRepository(Offer::class);
        $searchType->handleRequest($req);

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            //'cars' => $repository->findAll(),
            'offers' => $repository->findBy(['isExposed' => true]),
            'form' => $searchType->createView(),
            'services'=>$sr->findAll(),
            'testimonials'=> $tr->findApprovedTestimonials(),
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);

    }
}
