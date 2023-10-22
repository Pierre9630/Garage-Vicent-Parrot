<?php

namespace App\Controller;


use App\Entity\Contacts;
use App\Entity\Offers;
use App\Form\ContactsType;
use App\Repository\ContactsRepository;
use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactsRepository $contactRepository,OpeningHoursRepository $oh): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
            "openingHours" => $oh,
        ]);
    }

    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,OpeningHoursRepository $oh): Response
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);
        $offer = new Offers();

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtenez l'objet Contacts depuis le formulaire
            // Obtenez le nom du champ correct à partir de votre formulaire
            $offer = $contact->getOffer();
            if($this->isGranted('ROLE_ADMIN')){
                $contact->setIsApproved(true);
            }
            if ($offer !== null) {
                $offerReference = $offer->getReference();

                // Obtenez la valeur saisie dans le champ "referenceToAdd" du formulaire
                $subjectToAdd = $form->get('subject')->getData();

                // Fusionnez la référence de l'objet Offers avec la valeur du formulaire ContactsType
                $newSubject = $offerReference . ' ' . $subjectToAdd;

                // Mettez à jour l'objet Contacts (propriété subject) avec la référence de l'annonce en début de sujet
                $contact->setSubject($newSubject);

                $contact->setCreatedAt(new \DateTimeImmutable());

                // Enregistrez les modifications en base de données
                $entityManager->persist($contact);
                $entityManager->flush();
            }





            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
            "openingHours" => $oh,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contacts $contact,OpeningHoursRepository $oh): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
            "openingHours" => $oh,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contacts $contact, EntityManagerInterface $entityManager, OpeningHoursRepository $oh): Response
    {
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
            "openingHours" => $oh,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contacts $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/contact/approve/{id}", name: "app_contact_approve", methods: ["GET","POST"])]
    #[IsGranted("ROLE_USER","ROLE_ADMIN")] // Vous pouvez ajuster cette annotation pour gérer les autorisations
    public function approve(int $id, EntityManagerInterface $entityManager, ContactsRepository $cr): Response
    {
        // Récupérez le commentaire à partir de son ID
        $contact = $cr->find($id);

        // Vérifiez si le commentaire existe
        if (!$contact) {
            throw $this->createNotFoundException('Le commentaire n\'existe pas.');
        }

        // Marquez le commentaire comme approuvé (vous devez avoir une propriété "approved" dans votre entité Contact)
        $contact->setIsApproved(true);

        // Enregistrez les modifications dans la base de données
        $entityManager->flush();

        // Redirigez l'utilisateur vers la page précédente ou une autre page de votre choix
        // Dans cet exemple, nous redirigeons simplement vers la page d'accueil
        return $this->redirectToRoute('app_index');
    }

}
