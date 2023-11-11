<?php

namespace App\Controller;

use App\Entity\Information;
use App\Form\InformationType;
use App\Repository\InformationRepository;
use App\Repository\OpeningHourRepository;
use App\Service\DataService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/information')]
class InformationController extends AbstractController
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }
    #[Route('/', name: 'app_information_index', methods: ['GET'])]
    public function index(InformationRepository $informationRepository,  OpeningHourRepository $oh): Response
    {
        return $this->render('information/index.html.twig', [
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $informationRepository->findALl(),
        ]);
    }

    #[Route('/new', name: 'app_information_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, InformationRepository $informationRepository, OpeningHourRepository $oh): Response
    {
        $information = new Information();
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $active = $form->get('active')->getData();

            if ($active) {
                $information = $informationRepository->setActiveInformation($information);
            } else {
                $information->setActive(false);
            }
            $entityManager->persist($information);
            $entityManager->flush();

            return $this->redirectToRoute('app_information_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('information/new.html.twig', [
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}', name: 'app_information_show', methods: ['GET'])]
    public function show(Information $information, OpeningHourRepository $oh): Response
    {
        return $this->render('information/show.html.twig', [
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_information_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Information $information, EntityManagerInterface $entityManager, OpeningHourRepository $oh,InformationRepository $informationRepository): Response
    {
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $active = $form->get('active')->getData(); // Vérifier si la case active a été cochée
            $id = $form->get('id')->getData();
            // Active ou désactive la ligne en fonction de la case cochée
            if ($active) {
                $information = $informationRepository->find($id);
                $informationRepository->setActiveInformation($information);

            } else {
                $information->setActive(false);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_information_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('information/edit.html.twig', [
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}', name: 'app_information_delete', methods: ['POST'])]
    public function delete(Request $request, Information $information, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$information->getId(), $request->request->get('_token'))) {
            $entityManager->remove($information);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_information_index', [], Response::HTTP_SEE_OTHER);
    }
}
