<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="app_blog")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("cv-elhadi", name="app_cv_elhadi")
     */
    public function aboutCVElhadi(): Response
    {
        return $this->file('./../assets/img/CV_2022-03-19_Elhadi_Beddarem.pdf', null, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("cv-meddy", name="app_cv_meddy")
     */
    public function aboutCVMeddy(): Response
    {
        return $this->file('./../assets/img/CV_MeddySeize_2itech_2022.pdf', null, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
