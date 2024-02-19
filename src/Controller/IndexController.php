<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\InformationRepository;
use App\Repository\OpeningHourRepository;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use App\Service\DataService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class IndexController extends AbstractController
{
    private $dataService;

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
        if($searchType->isSubmitted() && $searchType->isValid()){
            //dd($cars);
            $criteria = $searchType->getData();
            //$offers = $repository->findBySearch($criteria);
            //dd($cars);
        }
        /*$pagination = $paginator->paginate(
            $repository->paginateOffers(),
            $req->query->get('page',1),
            5
        );*/
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



/*#[Route('/contact', name: 'app_img')]
    public function contact(Request $req, SluggerInterface $sl,EntityManagerInterface $entityManager){
        $contact = new Contact();
        $searchType = $this->createForm(ContactType::class,$contact);
        $repository = $entityManager->getRepository(Contact::class);
        $searchType->handleRequest($req);
        if($searchType->isSubmitted() && $searchType->isValid()){
            //dd($cars);
            $criteria = $searchType->getData();
            $contact = $repository->findBySearch($criteria);
            //dd($cars);
        }


        return $this->render('index/comment.html.twig',[

            'contact' => $contact,
            'form' => $searchType->createView(),
        ]);
    }*/


}
