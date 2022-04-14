<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\JeuxvideoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Security("is_granted('ROLE_USER')")
     */
    public function createCategorie(CategorieRepository $categorieRepo): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepo->findAll(),
        ]);
    }

    /**
     * @Route("/categorie/{slug}", name="app_categorie", methods={"GET"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function show(CategorieRepository $categorieRepository, $slug): Response
    {
        // dd($categorieRepository->findByGame($slug));
        // dd($categorieRepository->findBy(array('slug' => $slug)));
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorieRepository->findBySlug($slug),
            // 'jeuxvideo' => $categorieRepository->findByGame(array($slug))
        ]);
    }
}
