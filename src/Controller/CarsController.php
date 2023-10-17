<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Images;
use App\Entity\OpeningHours;
use App\Form\CarsType;
use App\Repository\CarsRepository;

use App\Repository\OffersRepository;
use App\Repository\OpeningHoursRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars')]
class CarsController extends AbstractController
{
    #[Route('/', name: 'app_cars_index', methods: ['GET'])]
    public function index(CarsRepository $carsRepository, OpeningHoursRepository $oh): Response
    {

        return $this->render('cars/index.html.twig', [
            'cars' => $carsRepository->findAll(),
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cars_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,OpeningHoursRepository $oh): Response
    {
        $car = new Cars();
        $carRepository = $entityManager->getRepository(Cars::class);
        $form = $this->createForm(CarsType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $car->setReference($carRepository->generateReference());
            $car->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_cars_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cars/new.html.twig', [
            'car' => $car,
            'form' => $form,
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_cars_show', methods: ['GET'])]
    public function show(Cars $car, OpeningHoursRepository $oh): Response
    {
        return $this->render('cars/show.html.twig', [
            'car' => $car,
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cars_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cars $car, EntityManagerInterface $entityManager, PictureService $pictureService, OpeningHoursRepository $oh): Response
    {
        $form = $this->createForm(CarsType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('app_cars_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cars/edit.html.twig', [
            'car' => $car,
            'form' => $form,
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_cars_delete', methods: ['POST'])]
    public function delete(Request $request, Cars $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cars_index', [], Response::HTTP_SEE_OTHER);
    }



}
