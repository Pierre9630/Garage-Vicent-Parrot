<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Contact;
use App\Entity\Image;
use App\Entity\Offer;
use App\Entity\OpeningHour;
use App\Form\ContactShowOfferType;
use App\Form\ContactType;
use App\Form\OfferEditType;
use App\Form\OfferType;
use App\Repository\ContactRepository;
use App\Repository\OfferRepository;
use App\Repository\OpeningHourRepository;
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
class OfferController extends AbstractController
{


    #[Route('/', name: 'app_offers_index', methods: ['GET'])]
    public function index(OfferRepository $offersRepository, OpeningHourRepository $oh): Response
    {

        return $this->render('offers/index.html.twig', [
            'offers' => $offersRepository->findAll(),
            'openingHours' => $oh->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_offers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PictureService $pictureService, OpeningHourRepository $oh): Response
    {
        $offer = new Offer();
        $offerRepository = $entityManager->getRepository(Offer::class);
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $car = $offer->getCar();
            $existingOffer = $offerRepository->findOneBy(['car' => $car]);

            if ($existingOffer) {
                throw new \Exception('Cette voiture est déjà associé à une autre annonce !.');
            }
            
            $offer->setReference($offerRepository->generateReference());

            $offer->setCreatedAt(new \DateTimeImmutable());
            //dd($offerRepository->generateReference());
            //On rajoute les images
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                //définir le dossier de destination
                $folder = 'cars';

                //Appel du Service PictureService.php
                $file = $pictureService->add($image, $folder);

                $img = new Image();
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


    #[Route('/show/{id}', name: 'app_offers_show', methods: ['GET',"POST"])]
    public function show(Request $request,Offer $offer, OpeningHourRepository $oh, ContactRepository $cr,EntityManagerInterface $entityManager): Response
    {

        $comment = new Contact();
        $commentForm = $this->createForm(ContactShowOfferType::class, $comment);
        $commentForm->handleRequest($request);
        // Récupérer les commentaires approuvés liés à l'offre
        $approvedComments = $cr->findApprovedComments($offer);


        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Associez le commentaire à l'offre en cours de visualisation
            $comment->setOffer($offer);
            $comment->setCreatedAt(new \DateTimeImmutable());

            // Validez et persistez le commentaire dans la base de données
            $entityManager->persist($comment);
            $entityManager->flush();

            // Redirigez l'utilisateur vers la page de l'offre après l'ajout du commentaire
            return $this->redirectToRoute('app_offers_show', ['id' => $offer->getId()]);
        }
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
            'approvedComments' => $approvedComments,
            'commentForm' => $commentForm->createView(),
            //'comments' => $cr->findApprovedComments(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_offers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer, EntityManagerInterface $entityManager, PictureService $pictureService, OpeningHourRepository $oh, ContactRepository $cr): Response
    {
        $offer= $entityManager->getRepository(Offer::class)->find($offer->getId());
        if (!$offer) {
            throw $this->createNotFoundException('L\'entité n\'a pas été trouvée.');
        }
        $form = $this->createForm(OfferEditType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $offer->setModifiedAt(new \DateTime());
            $images = $form->get('images')->getData();

            if (!empty($images)) {
                $folder = 'cars';

                foreach ($images as $image) {
                    $file = $pictureService->add($image, $folder);

                    $img = new Image();
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
    public function delete(Request $request, Offer $offer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
    }



}
