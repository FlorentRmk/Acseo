<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ContactController extends AbstractController
{
    /**
     * @Route("/admin/contact", name="contact_admin_panel")
     */
    public function index(): Response
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->getContactGrouByEmail();

        return $this->render('contact/index.html.twig', [
            'emails' => $contacts,
        ]);
    }

    /**
     * @Route("/contact/new", name="contact_new")
     */
    public function new(Request $request, ContactManager $contactManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactManager->new($contact);
            $this->addFlash('success', 'question sent to administrator');

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contact/process/{contact}", name="contact_process")
     */
    public function processContact(Contact $contact): Response
    {
        $contact->setChecked(true);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(true);
    }

}
