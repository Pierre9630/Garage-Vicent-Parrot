<?php

namespace App\Controller;


use App\Entity\Testimonial;
use App\Form\TestimonialType;
use App\Repository\TestimonialRepository;
use App\Service\DataService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/testimonial')]
class TestimonialController extends AbstractController
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }
    #[Route('/', name: 'app_testimonial_index', methods: ['GET'])]
    public function index(TestimonialRepository $testimonialRepository): Response
    {
        return $this->render('testimonial/index.html.twig', [
            'testimonials' => $testimonialRepository->findAll(),
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/new', name: 'app_testimonial_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $testimonial = new Testimonial();
        $form = $this->createForm(TestimonialType::class, $testimonial);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $acceptConditions = $form->get('conditions')->getData();

            // Vérifier si la case a été cochée
            if ($acceptConditions === true) {
                // Case cochée
                $session = $request->getSession();
                $testimonial->SetCreatedAt(new \DateTimeImmutable());
                $entityManager->persist($testimonial);
                $entityManager->flush();
                $session->getFlashBag()->add('success', 'Avis Envoyée');

                //$this->addFlash('success', 'Avis Ajouté !');
                return $this->redirectToRoute('app_testimonial_index_sucess', [], Response::HTTP_SEE_OTHER);
            } else {
                throw new \Exception('La case "J\'accepte les conditions générales" doit être cochée.');
            }

        }

        return $this->render('testimonial/new.html.twig', [
            'testimonial' => $testimonial,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/sucess', name: 'app_testimonial_index_sucess', methods: ['GET'])]
    public function sucess(){

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}', name: 'app_testimonial_show', methods: ['GET'])]
    public function show(Testimonial $testimonial): Response
    {
        return $this->render('testimonial/show.html.twig', [
            'testimonial' => $testimonial,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_testimonial_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Testimonial $testimonial, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TestimonialType::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_testimonial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('testimonial/edit.html.twig', [
            'testimonial' => $testimonial,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}', name: 'app_testimonial_delete', methods: ['POST'])]
    public function delete(Request $request, Testimonial $testimonial, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$testimonial->getId(), $request->request->get('_token'))) {
            $entityManager->remove($testimonial);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_testimonial_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/contact/approve/{id}", name: "app_testimonial_approve", methods: ["GET","POST"])]
    #[IsGranted("ROLE_USER")]
    public function approve(string $id, EntityManagerInterface $entityManager, TestimonialRepository $tr): Response
    {

        $testimonial = $tr->find($id);

        // Vérifier si le commentaire existe
        if (!$testimonial) {
            throw $this->createNotFoundException('Le commentaire n\'existe pas.');
        }

        // Marquer le commentaire comme approuvé
        $testimonial->setIsApproved(true);

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_index');
    }
}
