<?php

namespace App\Controller;

use App\Entity\OpeningHour;
use App\Form\OpeningHourType;
use App\Repository\OpeningHourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DataService;

#[Route('/openinghours')]
class OpeningHourController extends AbstractController
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }
    #[Route('/', name: 'app_opening_hours_index', methods: ['GET'])]
    public function index(OpeningHourRepository $or): Response
    {

        return $this->render('opening_hours/index.html.twig', [
            'openingHours' => $or->findAll(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    /*#[Route('/new', name: 'app_opening_hours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $openingHour = new OpeningHours();
        $form = $this->createForm(OpeningHoursType::class, $openingHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($openingHour);
            $entityManager->flush();

            return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('opening_hours/new.html.twig', [
            'openingHours' => $openingHour,
            'form' => $form,
        ]);
    }*/

    #[Route('/{id}', name: 'app_opening_hours_show', methods: ['GET'])]
    public function show(OpeningHour $openingHour): Response
    {
        return $this->render('opening_hours/show.html.twig', [
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_opening_hours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OpeningHour $openingHour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OpeningHourType::class, $openingHour);
        $form->handleRequest($request);
        $WeekDayTrans = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
        ];
        

        if ($form->isSubmitted() && $form->isValid()) {
            $openingHours = $form->getData(); // Obtenir l'objet OpeningHours complet
            $selectedDayOfWeek = $openingHours->getDayOfWeek(); // Obtenir le jour de la semaine sélectionné sous forme de chaîne
             // Récupérer la valeur de dayOfWeek en anglais
            $englishDay = $openingHour->getDayOfWeek();

        // Traduire la valeur en français à partir du tableau de traduction
            $frenchDay = $WeekDayTrans[$englishDay];


            $entityManager->flush();

            return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('opening_hours/edit.html.twig', [
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
            'form' => $form,

        ]);
    }

    /*#[Route('/{id}', name: 'app_opening_hours_delete', methods: ['POST'])]
    public function delete(Request $request, OpeningHours $openingHour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$openingHour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($openingHour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_opening_hours_index', [], Response::HTTP_SEE_OTHER);
    }*/
}
