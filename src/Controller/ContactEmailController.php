<?php

namespace App\Controller;

use App\Entity\ContactEmail;
use App\Form\ContactEmailType;
use App\Service\ContactEmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactEmailController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_email")
     */
    public function index(Request $request,ContactEmailService $contactEmailService): Response
    {
        $contact = new ContactEmail();
        $form = $this->createForm(ContactEmailType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $contactEmailService->persistContactEmail($contact);

            return $this->redirectToRoute('contact_email');
        }
        return $this->render('contact_email/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
