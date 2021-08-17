<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/a-propos", name="a-propos")
     * @throws NonUniqueResultException
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('about/index.html.twig', [
            'peintre' => $userRepository->findPeintre(),
        ]);
    }
}
