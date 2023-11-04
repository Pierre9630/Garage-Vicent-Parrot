<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Contact;
use App\Entity\Offer;
use App\Entity\OpeningHour;
use App\Form\ContactType;
use App\Form\OfferType;
use App\Form\SearchType;
//use App\Model\CarsData;
use App\Repository\CarRepository;
//use App\Service\UploadPhoto;
//use Carbon\Carbon;
//se Carbon\Doctrine\DateTimeType;
use App\Repository\OfferRepository;
use App\Repository\OpeningHourRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
//use http\Env\Request;
use Knp\Component\Pager\PaginatorInterface;
//use Spatie\OpeningHours\OpeningHours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use App\Service\ResSlots;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;


class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager,Request $req,PaginatorInterface $paginator,
        ServiceRepository $sr, OpeningHourRepository $oh): Response
    {

        $offers = new Offer();
        $searchType = $this->createForm(OfferType::class,$offers);
        $repository = $entityManager->getRepository(Offer::class);
        $searchType->handleRequest($req);
        if($searchType->isSubmitted() && $searchType->isValid()){
            //dd($cars);
            $criteria = $searchType->getData();
            $offers = $repository->findBySearch($criteria);
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
            'openingHours' => $oh->findAll(),
            'services'=>$sr->findAll()
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
