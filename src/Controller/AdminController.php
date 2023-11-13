<?php

namespace App\Controller;

use App\Entity\Information;
use App\Entity\Offer;
use App\Entity\OpeningHour;
use App\Entity\Service;
use App\Entity\User;
use App\Form\InformationType;
use App\Form\OpeningHourType;
use App\Form\ServiceType;
use App\Form\UserType;
use App\Form\AdminType;
use App\Repository\ContactRepository;
use App\Repository\InformationRepository;
use App\Repository\OpeningHourRepository;
use App\Repository\TestimonialRepository;
use App\Repository\UserRepository;
use App\Service\DataService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;



#[Route('/admin')]
class AdminController extends AbstractController
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }
    #[Route('/', name: 'app_admin_index')]
    public function index(
        UserRepository $userRepository,
        Request $request,
        PaginatorInterface $paginator,
        ContactRepository $cr,
        TestimonialRepository $tr,
        FormHandler $formHandler, // Supposons que vous ayez un service pour gérer les formulaires
    ): Response {
        $openingHourForm = $this->createForm(OpeningHourType::class);
        $serviceForm = $this->createForm(ServiceType::class);
        $informationForm = $this->createForm(InformationType::class);

        $formHandler->handleServiceForm($serviceForm, $request);
        $formHandler->handleOpeningHourForm($openingHourForm, $request);
        $formHandler->handleInformationForm($informationForm, $request);

        $pagination = $paginator->paginate(
            $userRepository->paginateUsers(),
            $request->query->get('page', 1),
            25 // nombre d'utilisateurs par page
        );

        return $this->render('admin/index.html.twig', [
            'users' => $pagination,
            //'cars'=>$repository->findAll(),
            'contacts'=>$cr->findNotApproved(),
            'testimonials'=>$tr->findNotApproved(),
            'openingHourForm' => $openingHourForm->createView(),
            'serviceForm' => $serviceForm->createView(),
            'informationForm' => $informationForm->createView(),
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }
    #[Route('/new', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher, OpeningHourRepository $oh, InformationRepository $ir ): Response
    {
        $admin = new User();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $admin->setPassword(
                $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('password')->getData()
                )
            );
            $userRepository->save($admin, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new.html.twig', [
            'user' => $admin,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(User $admin,OpeningHourRepository $oh): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $admin,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $admin, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setPassword(
                $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('password')->getData()
                )
            );

            $userRepository->save($admin, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'user' => $admin,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $admin, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $userRepository->remove($admin, true);
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/dashboard', name: 'app_admin_dash', methods: ['POST'])]
    public function dash(Request $request, User $admin, InformationRepository $ir, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Offer::class);

        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }


}


