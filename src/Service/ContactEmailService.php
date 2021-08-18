<?php

namespace App\Service;

use App\Entity\ContactEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactEmailService
{
    private EntityManagerInterface $em;
    private FlashBagInterface $flashBag;

    /**
     * @param EntityManagerInterface $em
     * @param FlashBagInterface $flashBag
     */
    public function __construct(EntityManagerInterface $em, FlashBagInterface $flashBag)
    {
        $this->em = $em;
        $this->flashBag = $flashBag;
    }
    public function persistContactEmail(ContactEmail $contactEmail):void
    {
        $contactEmail->setIsSend(false)
        ->setCreatedAt(new \DateTimeImmutable('now'));
        $this->em->persist($contactEmail);
        $this->em->flush();
        $this->flashBag->add('success','Votre message a bien été envoyé, merci');


    }
    public function isSend(ContactEmail $contactEmail):void{
        $contactEmail->setIsSend(true);
        $this->em->persist($contactEmail);
        $this->em->flush();
    }

}