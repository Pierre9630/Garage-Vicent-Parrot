<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\DataService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/contact')]
class   ContactController extends AbstractController
{
    private DataService $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(Request $request,ContactRepository $contactRepository,PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $pagination = $paginator->paginate(
            $contactRepository->paginateContacts(), // Paginate Contacts request Paginer les demandes de contacts
            $request->query->get('page',1),
            15 // Number contact per page nombre contacts par page
        );
        return $this->render('contact/index.html.twig', [
            'contacts' => $pagination,
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


        if ($form->isSubmitted() && $form->isValid()) {
            // Get form contact object Obtenir l'objet Contacts depuis le formulaire
            $session = $request->getSession();
            $offer = $contact->getOffer();
            // If the field generalinquiry is checked Vérifier si la case à cocher isGeneralInquiry est cochée
            $isGeneralInquiry = $form->get('isGeneralInquiry')->getData();

            // Make related proprety offer at null if generalinquirt is checked Mettre à jour l'offre associée
            // à null si la case est cochée
            if ($isGeneralInquiry) {
                $contact->setOffer(null);
            }
            if($this->isGranted('ROLE_USER')){ // si un employée envoie la demande alors c'est approuvé
                $contact->setIsApproved(true);
            }
            if ($offer !== null) {
                $offerReference = $offer->getReference();

                // Get the value entered in field "subject"
                // Obtenir la valeur saisie dans le champ "subject" du formulaire
                $subjectToAdd = $form->get('subject')->getData();

                // Merge reference and subject Fusionner la référence
                // de l'objet Offers avec la valeur du formulaire ContactsType
                $newSubject = '['. $offerReference . ']' . ' ' . $subjectToAdd;

                // Update object Contact with associated reference Mettre à jour l'objet Contacts (propriété subject)
                // avec la référence de l'annonce en début de sujet
                $contact->setSubject($newSubject);

                //$this->addFlash('success', 'Demande de Contact Envoyé!');
            }
            // Save the modifications in db Enregistrer les modifications en base de données
            $contact->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($contact);
            $entityManager->flush();
            $session->getFlashBag()->add('success', 'Demande de contact Envoyée');
            //dd('test');
            return $this->redirectToRoute('app_contact_index_sucess', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }
    #[Route('/sucess', name: 'app_contact_index_sucess', methods: ['GET'])]
    public function sucess():RedirectResponse
    {

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);

    }
    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
            'openingHours' => $this->dataService->getOpeningHours(),
            'information' => $this->dataService->getActiveInformation(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if generalinquiry is checked Vérifier si la case à cocher isGeneralInquiry est cochée
            $isGeneralInquiry = $form->get('isGeneralInquiry')->getData();

            // Update related proprety offer at null if generalinquirt is checked
            //  Mettre à jour l'offre associée à null si la case est cochée
            if ($isGeneralInquiry) {
                $contact->setOffer(null);
            }
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
    #[IsGranted("ROLE_USER")]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        //dd($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token')));
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {


            if ($this->isGranted('ROLE_ADMIN')) {
                $entityManager->remove($contact);
                $entityManager->flush();
                // Si c'est un admin, redirection vers l'index admin

                return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // If a user is connected return to previous page
                // Si c'est un utilisateur, retour à la page précédente s'il existe
                $referer = $request->headers->get('referer');
                if ($referer) {
                    $entityManager->remove($contact);
                    $entityManager->flush();
                    return $this->redirect($referer);
                }
            }

        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/contact/approve/{id}", name: "app_contact_approve", methods: ["GET","POST"])]
    #[IsGranted("ROLE_USER")]
    public function approve(string $id,Request $request, EntityManagerInterface $entityManager,
                            ContactRepository $cr): RedirectResponse
    {
        // Get comment ID Récupérer le commentaire à partir de son ID
        $contact = $cr->find($id);
        $referer = $request->headers->get('referer');
        // Check if comment exist Vérifier si le commentaire existe
        if (!$contact) {
            throw $this->createNotFoundException('Le commentaire n\'existe pas.');
        }

        // Set comment approved Marquer le commentaire comme approuvé
        $contact->setIsApproved(true);

        // Save modifications in db Enregistrer les modifications dans la base de données
        $entityManager->flush();

        // Redirect user/visitor to previous page Rediriger
        // l'utilisateur/visiteur vers la page précédente ou un autre page
        return new RedirectResponse($referer);
    }

}
