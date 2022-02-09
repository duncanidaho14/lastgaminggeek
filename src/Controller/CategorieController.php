<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(CategorieRepository $categorieRepo): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepo->findAll(),
        ]);
    }

    /**
     * @Route("/categorie/create", name="create_categorie")
     */
    public function createCategorie(CategorieRepository $categorieRepo): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepo->findAll(),
        ]);
    }
}
