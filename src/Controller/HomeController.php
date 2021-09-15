<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\JeuxvideoRepository;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Classes\Cache;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/accueil", name="accueil")
     */
    public function index(CacheInterface $cache, UserRepository $userRepo, JeuxvideoRepository $jeuxvideoRepo): Response
    {
        $user = $userRepo->findAll();
        $jeux = $jeuxvideoRepo->findAll();
        
        
        
        // $homeCacheJeux = $cache->addCache('jeux', function(){
        //     return $jeux;
        // });

        // for ($j=0; $j < count($jeux); $j++) { 
        //     $jeu = $jeux[$j];
            
        // }
        // $someJeux = $cache->get($jeu->getId(), function(ItemInterface $item) use ($jeu)
        // {
        //     $someJeux = $jeu->getId();
        //     return $someJeux;
        // });
        
        return $this->render('home/index.html.twig', [
            'users' => $user,
            'jeuxvideo' => $jeux
        ]);
    }
}
