<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PaintingRepository $paintingRepository,BlogPostRepository $blogPostRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'paintingList' => $paintingRepository->getLastPaintingList(3),
            'blogpostList' => $blogPostRepository->getLastBlogpostList(3),
        ]);
    }
}
