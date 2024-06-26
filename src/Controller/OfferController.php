<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Image;
use App\Entity\Offer;
use App\Form\ContactShowOfferType;
use App\Form\OfferEditType;
use App\Form\OfferType;
use App\Repository\ContactRepository;
use App\Repository\OfferRepository;
use App\Service\DataService;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/offers')]
class OfferController extends AbstractController
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    #[Route('/', name: 'app_offers_index', methods: ['GET'])]
    public function index(Request $request,OfferRepository $offersRepository,PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $offersRepository->paginateOffers(),
            $request->query->get('page',1),
            15 //nombre voitures par page
        );
        return $this->render('offers/index.html.twig', [
            'offers' => $pagination,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/new', name: 'app_offers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,
                         FileUploader $fileUploader): Response
    {
        //  Instanciate class Offer Instancier la classe Offer
        $offer = new Offer();
        $offerRepository = $entityManager->getRepository(Offer::class);
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request); // Handle form request Gèrer de la requete à partir du form
        
        if ($form->isSubmitted() && $form->isValid()) {
            $car = $offer->getCar();
            $existingOffer = $offerRepository->findOneBy(['car' => $car]);

            if ($existingOffer) {
                throw new \Exception('Cette voiture est déjà associé à une autre annonce !.');
            }
            
            $offer->setReference($offerRepository->generateReference());

            $offer->setCreatedAt(new \DateTimeImmutable());
            //Add images On rajoute les images
            $images = $form->get('images')->getData();
            foreach ($images as $image) {

                $file = $fileUploader->upload($image);
                // Define target folder définir le dossier de destination
                //$folder = '/assets/uploadcars/';

                // Call PictureService Appel du Service PictureService.php
                //$file = $pictureService->add($image);
                //dd($folder . $file);
                $img = new Image();
                $img->setName($file);
                $offer->addImage($img);
            }
            $entityManager->persist($offer);
            $entityManager->flush();
            return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('offers/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }


    #[Route('/show/{id}', name: 'app_offers_show', methods: ['GET',"POST"])]
    public function show(Request $request,Offer $offer, ContactRepository $cr,
                         EntityManagerInterface $entityManager): Response
    {

        $comment = new Contact();
        $commentForm = $this->createForm(ContactShowOfferType::class, $comment);
        $commentForm->handleRequest($request);
        // Récupérer les commentaires approuvés liés à l'offre
        $approvedComments = $cr->findApprovedComments($offer);


        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Associer le commentaire à l'offre en cours de visualisation
            $session = $request->getSession();
            $comment->setOffer($offer);
            //Set offer reference on comment subject Mettre reference annonce entre crochets
            $comment->setSubject('['.$offer->getReference().']'. ' '.$comment->getSubject());
            $comment->setCreatedAt(new \DateTimeImmutable());

            // Valider et persister le commentaire dans la base de données
            $entityManager->persist($comment);
            $entityManager->flush();
            $session->getFlashBag()->add('success', 'Demande de contact Envoyée');
            // Rediriger l'utilisateur vers la page de l'offre après l'ajout du commentaire
            return $this->redirectToRoute('app_index', ['id' => $offer->getId()]); //app_offers_show
        }
        //$approvedContacts = $contactsRepository->findApprovedContactsForOffer($offer);

        // Ajouter les commentaires approuvés à l'objet Offer
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
// Utiliser le var_dump ou un autre moyen pour afficher la requête DQL
        //dd($debugSql);

        return $this->render('offers/show.html.twig', [
            'offer' => $offer,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
            'approvedComments' => $approvedComments,
            'commentForm' => $commentForm->createView(),
            //'comments' => $cr->findApprovedComments(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_offers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer, EntityManagerInterface $entityManager,
                         FileUploader $fileUploader): Response
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
                $delImages = $offer->getImages();
                // Supprimer chaque image associée
                foreach ($delImages as $image) {

                    $fileUploader->delete($image->getName());
                    $offer->removeImage($image);
                }
                foreach ($images as $image) {

                    $file = $fileUploader->upload($image);

                    $img = new Image();
                    $img->setName($file);
                    $offer->addImage($img);
                }

                $entityManager->flush();

                //$this->addFlash("success", "Annonce modifiée avec succès !");
                return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
            }


            $entityManager->flush();
            $this->addFlash("success", "Annonce modifiée avec succès !");
            return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offers/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_offers_delete', methods: ['POST'])]
    public function delete(Request $request, Offer $offer, EntityManagerInterface $entityManager,
                           FileUploader $fileUploader): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $images = $offer->getImages();
            // Supprimer chaque image associée
            foreach ($images as $image) {
                // Define target folder définir le dossier de destination
                $folder = '/assets/uploadcars/';
                //dd($folder . $image->getName());
                //$pictureService->delete($image->getName(),$folder);
                $fileUploader->delete($image->getName());

            }

            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offers_index', [], Response::HTTP_SEE_OTHER);
    }



}
