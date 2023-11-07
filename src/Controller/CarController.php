<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Image;
use App\Entity\OpeningHour;
use App\Form\CarType;
use App\Repository\CarRepository;

use App\Repository\OfferRepository;
use App\Repository\OpeningHourRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars')]
class CarController extends AbstractController
{
    #[Route('/', name: 'app_cars_index', methods: ['GET'])]
    public function index(CarRepository $carsRepository, OpeningHourRepository $oh): Response
    {

        return $this->render('cars/index.html.twig', [
            'cars' => $carsRepository->findAll(),
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cars_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,OpeningHourRepository $oh): Response
    {
        $car = new Car();
        $carRepository = $entityManager->getRepository(Car::class);
        $form = $this->createForm(CarType::class, $car);
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
    public function show(Car $car, OpeningHourRepository $oh): Response
    {
        return $this->render('cars/show.html.twig', [
            'car' => $car,
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cars_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, EntityManagerInterface $entityManager, PictureService $pictureService, OpeningHourRepository $oh): Response
    {
        $form = $this->createForm(CarType::class, $car);
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
    public function delete(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cars_index', [], Response::HTTP_SEE_OTHER);
    }



}