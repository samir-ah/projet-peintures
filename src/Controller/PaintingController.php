<?php

namespace App\Controller;

use App\Entity\Painting;
use App\Repository\PaintingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaintingController extends AbstractController
{
    private PaintingRepository $paintingRepository;
    private PaginatorInterface $paginator;
    private EntityManagerInterface $em;

    public function __construct
    (PaintingRepository $paintingRepository,
     EntityManagerInterface $em,
     PaginatorInterface $paginator
    )
    {
        $this->paintingRepository = $paintingRepository;
        $this->paginator = $paginator;
        $this->em = $em;
    }


    /**
     * @Route("/realisations", name="realisations")
     */
    public function index(Request $request): Response
    {
        $dql   = "SELECT p FROM App:Painting p";
        $query = $this->em->createQuery($dql);
        $paintingList = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6

        );
        return $this->render('painting/realisations.html.twig', [
            'paintingList' => $paintingList,
        ]);
    }
    /**
     * @Route("/realisations/{slug}", name="realisations_detail")
     */
    public function detail(Painting $painting): Response
    {
        return $this->render('painting/detail.html.twig', [
            'painting' => $painting,
        ]);
    }
}
