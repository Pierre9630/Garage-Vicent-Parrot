<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Offer;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\DataService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/contact')]
class ContactController extends AbstractController
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $offer = new Offer();

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtenez l'objet Contacts depuis le formulaire
            // Obtenez le nom du champ correct à partir de votre formulaire
            $offer = $contact->getOffer();
            if($this->isGranted('ROLE_ADMIN')){
                $contact->setIsApproved(true);
            }
            if ($offer !== null) {
                $offerReference = $offer->getReference();

                // Obtenir la valeur saisie dans le champ "referenceToAdd" du formulaire
                $subjectToAdd = $form->get('subject')->getData();

                // Fusionner la référence de l'objet Offers avec la valeur du formulaire ContactsType
                $newSubject = $offerReference . ' ' . $subjectToAdd;

                // Mettre à jour l'objet Contacts (propriété subject) avec la référence de l'annonce en début de sujet
                $contact->setSubject($newSubject);

                $contact->setCreatedAt(new \DateTimeImmutable());

                // Enregistrer les modifications en base de données
                $entityManager->persist($contact);
                $entityManager->flush();
                $this->addFlash('success', 'Avis Envoyé !');
            }





            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact,OpeningHourRepository $oh): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager,): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }


    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/contact/approve/{id}", name: "app_contact_approve", methods: ["GET","POST"])]
    #[IsGranted("ROLE_USER")]
    public function approve(string $id, EntityManagerInterface $entityManager, ContactRepository $cr): Response
    {
        // Récupérer le commentaire à partir de son ID
        $contact = $cr->find($id);

        // Vérifier si le commentaire existe
        if (!$contact) {
            throw $this->createNotFoundException('Le commentaire n\'existe pas.');
        }

        // Marquer le commentaire comme approuvé
        $contact->setIsApproved(true);

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        // Rediriger l'utilisateur vers la page précédente ou un autre page
        return $this->redirectToRoute('app_admin_index');
    }

}
