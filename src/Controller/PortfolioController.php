<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PaintingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/portfolio", name="portfolio")
     * @throws NonUniqueResultException
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categoryList = $categoryRepository->findAll();
        foreach ($categoryList as $category) {
            $dql = "SELECT p FROM App:Painting p INNER JOIN p.category c WHERE c.id = :categoryId ORDER BY p.id DESC";
            $query = $this->em->createQuery($dql);
            $painting = $query->setMaxResults(1)
                ->setParameter('categoryId', $category->getId())
                ->getOneOrNullResult();

            $category->lastPainting = $painting;
        }
//        dd($categoryList);
        return $this->render('portfolio/index.html.twig', [
            'categoryList' => $categoryList,
        ]);
    }/**
     * @Route("/categorie/{slug}", name="portfolio_category")
     */
    public function category(Category $category,PaintingRepository $paintingRepository): Response
    {
        $paintingList = $paintingRepository->findAllPortfolio($category);
        return $this->render('portfolio/category.html.twig', [
            'paintingList' => $paintingList,
            'category' => $category
        ]);
    }
}
