<?php

namespace App\Controller;

//use App\Entity\Products;
use AllowDynamicProperties;
use App\Entity\OpeningHours;
use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[AllowDynamicProperties]
#[Route('/user')]//, name:"app_user")]
class UserController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, EntityManagerInterface $entityManager, OpeningHours $oh): Response
    {
        $repository = $entityManager->getRepository(User::class);

        return $this->render('user/index.html.twig', [
            'user' => $this->security->getUser(),
            'openingHours' => $oh,
            //'admins' => $userRepository->foundAdmins(),
            //'products'=>$repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET','POST'])]
    public function new(Request $request, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher, OpeningHours $oh, EntityManagerInterface $entityManager ): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            //$userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'openingHours' => $oh,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET','POST'])]
    public function show(User $user, OpeningHours $oh): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'openingHours' => $oh,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET','POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, OpeningHours $oh): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'openingHours' => $oh,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['GET','POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
