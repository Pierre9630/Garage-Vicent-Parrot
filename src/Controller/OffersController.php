<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Contacts;
use App\Entity\Images;
use App\Entity\Offers;
use App\Entity\OpeningHours;
use App\Form\OffersType;
use App\Repository\ContactsRepository;
use App\Repository\OffersRepository;
use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PictureService;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\SearchService;

#[Route('/offers')]
class OffersController extends AbstractController
{


    #[Route('/', name: 'app_offers_index', methods: ['GET'])]
    public function index(OffersRepository $offersRepository, OpeningHoursRepository $oh): Response
    {

        return $this->render('offers/index.html.twig', [
            'offers' => $offersRepository->findAll(),
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_offers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PictureService $pictureService, OpeningHoursRepository $oh): Response
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
            foreach ($images as $image) {
                //définir le dossier de destination
                $folder = 'cars';

                //Appel du Service PictureService.php
                $file = $pictureService->add($image, $folder, 800, 600);

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
            'openingHours' => $oh->findAll(),
        ]);
    }


    #[Route('/show/{id}', name: 'app_offers_show', methods: ['GET'])]
    public function show(Offers $offer, OpeningHoursRepository $oh): Response
    {
        //$approvedContacts = $contactsRepository->findApprovedContactsForOffer($offer);

        // Ajoutez les commentaires approuvés à l'objet Offer
        //$offer->setApprovedContacts($approvedContacts);
        /*$criteria = [
            'offer' => $offer, // Filtrer par l'offre spécifique
            'isApproved' => 1, // Filtrer les commentaires approuvés (true)
        ];

        $approvedComments = $cr->findBy($criteria);
        $debugSql = $cr->createQueryBuilder('c')
            ->where('c.offer = :offer')
            ->andWhere('c.isApproved = :isApproved')
            ->setParameters($criteria)
            ->getQuery()
            ->getSQL();
            //->getResult();
*/
// Utilisez le var_dump ou un autre moyen pour afficher la requête SQL
        //dd($debugSql);

        return $this->render('offers/show.html.twig', [
            'offer' => $offer,
            'openingHours' => $oh->findAll(),
            //'comments' => $cr->findApprovedComments(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_offers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offers $offer, EntityManagerInterface $entityManager, PictureService $pictureService, OpeningHoursRepository $oh, ContactsRepository $cr): Response
    {
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setModifiedAt(new \DateTime());
            $images = $form->get('images')->getData();

            if (!empty($images)) {
                $folder = 'cars';

                foreach ($images as $image) {
                    $file = $pictureService->add($image, $folder, 800, 600);

                    $img = new Images();
                    $img->setName($file);
                    $offer->addImage($img);
                }

                $entityManager->flush();

                $this->addFlash("success", "Annonce modifiée avec succès !");
                return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
            }

            // S'il n'y a pas d'images, vous pouvez simplement appeler flush ici
            $entityManager->flush();
            $this->addFlash("success", "Annonce modifiée avec succès !");
            return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offers/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_offers_delete', methods: ['POST'])]
    public function delete(Request $request, Offers $offer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
    }



}
