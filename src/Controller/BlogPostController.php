<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogPostController extends AbstractController
{
    private PaginatorInterface $paginator;
    private BlogPostRepository $blogPostRepository;
    private EntityManagerInterface $em;

    public function __construct
    (BlogPostRepository $blogPostRepository,
     EntityManagerInterface $em,
     PaginatorInterface $paginator
    )
    {
        $this->paginator = $paginator;
        $this->blogPostRepository = $blogPostRepository;
        $this->em = $em;
    }

    /**
     * @Route("/actualites", name="actualites")
     */
    public function index(Request $request): Response
    {
        $dql   = "SELECT b FROM App:Blogpost b";
        $query = $this->em->createQuery($dql);
        $blogpostList = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('blog_post/actualites.html.twig', [
            'blogpostList' => $blogpostList,
        ]);
    }
}
