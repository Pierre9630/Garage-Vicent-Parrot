<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\SearchFormType;
//use App\Model\CarsData;
use App\Repository\CarsRepository;
//use App\Service\UploadPhoto;
//use Carbon\Carbon;
//se Carbon\Doctrine\DateTimeType;
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
    public function index(EntityManagerInterface $entityManager,Request $req,PaginatorInterface $paginator): Response
    {
        $cars = new Cars();
        $searchType = $this->createForm(SearchFormType::class,$cars);
        $repository = $entityManager->getRepository(Cars::class);
        $searchType->handleRequest($req);
        if($searchType->isSubmitted() && $searchType->isValid()){
            //dd($cars);
            $criteria = $searchType->getData();
            $cars = $repository->findBySearch($criteria);
            //dd($cars);
        }
        $pagination = $paginator->paginate(
            $repository->paginateCars(),
            $req->query->get('page',1),
            5
        );
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            //'cars' => $repository->findAll(),
            'cars' => $pagination,
            'form' => $searchType->createView()
        ]);

    }

    #[Route('/res', name: 'app_res')]
    public function res(EntityManagerInterface $em, ResSlots $resslots,  $date = 0): Response
    {

        //dd(\DateTime::createFromFormat('Y-m-d H:i:s','2023-05-02 00:00:00'));
        //dd($date);
        
        //$finaldate = $date->format('Y-m-d');
        //dd($finaldate);

        $numberslots = $resslots->getAvailableTimeSlots($em,Carbon::now(),2);
        //dd($numberslots);
        $openingHours = OpeningHours::create([
            'monday' => ['12:00-14:00', '19:00-22:00'],
            'tuesday' => ['12:00-14:00', '19:00-22:00'],
            'thursday' => ['12:00-14:00', '19:00-22:00'],
            'friday' => ['12:00-14:00', '19:00-21:00'],
            'saturday' => ['12:00-14:00', '19:00-22:00'],
            'sunday' => ['12:00-14:00'],
        ]);
        /*$test = [
            0 => [
                 'monday' => '12:00-14:00'
            ],
            1 =>['12:30-13:30'],
        ];
        $people = array(
            2 => array(
                'name' => 'John',
                'fav_color' => 'green',
                'date' => '02-05-2026',
            ),
            5=> array(
                'name' => 'Samuel',
                'fav_color' => 'blue'
            )
        );
        dd($people);*/

        return $this->render('index/reservation.html.twig', [
            'controller_name' => 'IndexController',
            'resslots' => $numberslots,

            //dd($openingHours->forWeek()),
        ]);
    }
#[Route('/img', name: 'app_img')]
    public function img(Request $req, SluggerInterface $sl){

        $uploader = new UploadPhoto($req->get('file'), $sl);

        return $this->render('index/img.html.twig',[
            'controller_name' => 'IndexController',
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
