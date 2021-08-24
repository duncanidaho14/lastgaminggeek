<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\JeuxvideoRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/accueil", name="accueil")
     */
    public function index(UserRepository $userRepo, JeuxvideoRepository $jeuxvideoRepo): Response
    {
        $user = $userRepo->findAll();
        $jeux = $jeuxvideoRepo->findAll();

        return $this->render('home/index.html.twig', [
            'users' => $user,
            'jeuxvideo' => $jeux
        ]);
    }
}
