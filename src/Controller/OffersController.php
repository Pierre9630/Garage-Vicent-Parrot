<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Images;
use App\Entity\Offers;
use App\Form\OffersType;
use App\Repository\OffersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PictureService;

#[Route('/offers')]
class OffersController extends AbstractController
{
    #[Route('/', name: 'app_offers_index', methods: ['GET'])]
    public function index(OffersRepository $offersRepository): Response
    {
        return $this->render('offers/index.html.twig', [
            'offers' => $offersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_offers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PictureService $pictureService): Response
    {
        $offer = new Offers();
        $offerRepository = $entityManager->getRepository(Offers::class);
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setReference($offerRepository->generateReference());

            $offer->setCreatedAt(new \DateTimeImmutable());
            //dd($offerRepository->generateReference());
            //On rajoute les images
            $images = $form->get('images')->getData();
            foreach($images as $image){
                //définir le dossier de destination
                $folder = 'cars';

                //Appel du Service PictureService.php
                $file = $pictureService->add($image,$folder,800,600);

                $img = new Images();
                $img->setName($file);
                $offer->addImage($img);


            }
            $entityManager->persist($offer);
            $entityManager->flush();
            return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
        }
        /*$offer = new Offers();
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
        }*/

        return $this->render('offers/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offers_show', methods: ['GET'])]
    public function show(Offers $offer): Response
    {
        return $this->render('offers/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offers $offer, EntityManagerInterface $entityManager,PictureService $pictureService): Response
    {
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setModifiedAt(new \DateTimeImmutable());
            $images = $form->get('images')->getData();
            foreach($images as $image){
                //définir le dossier de destination
                $folder = 'cars';

                //Appel du Service PictureService.php
                $file = $pictureService->add($image,$folder,800,600);

                $img = new Images();
                $img->setName($file);
                $offer->addImage($img);

            }
            $entityManager->flush();

            return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offers/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offers_delete', methods: ['POST'])]
    public function delete(Request $request, Offers $offer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
    }
}
