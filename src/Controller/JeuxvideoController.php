<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JeuxvideoRepository;

class JeuxvideoController extends AbstractController
{
    /**
     * @Route("/jeuxvideo", name="jeuxvideo")
     */
    public function index(): Response
    {
        return $this->render('jeuxvideo/index.html.twig', [
            'controller_name' => 'JeuxvideoController',
        ]);
    }

    /**
     * @Route("/jeuxvideo/{slug}", name="article")
     */
    public function displayJeuxvideo(JeuxvideoRepository $jeuxvideoRepository, $slug): Response
    {

        return $this->render('jeuxvideo/index.html.twig', [
            'jeuxvideo' => $jeuxvideoRepository->findOneBySlug($slug)
        ]);
    }
}
