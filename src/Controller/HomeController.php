<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\JeuxvideoRepository;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Cache\ItemInterface;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/accueil", name="accueil")
     */
    public function index(CacheInterface $cache, UserRepository $userRepo, JeuxvideoRepository $jeuxvideoRepo): Response
    {

        /*
        Système de cache: Avec le composant Filesystem Adapter(FSA) , on utilise le cache pour les performances d'affichages, 
        des articles de jeux vidéo, et utilisateur
        */ 

        // On initialise le cache
        $cache = new FilesystemAdapter();
        //On cherche les utilisateurs selon le paramètre entré dans la fonction
        $user = $userRepo->findAll();
        // On cherche le répertoire de jeux vidéos selon le paramètre entré dans la fonction
        $jeux = $jeuxvideoRepo->findAll();

        //On trouve les articles et on les met dans une liste.
        for ($j=0; $j < count($jeux); $j++) { 
            $jeu = $jeux[$j];
            
        }
        $someJeux = $cache->get($jeu->getId(), function(ItemInterface $item) use ($jeu)
        {
            //Si il existe pas de liste d'article dans le cache, la fonction FSA ajoute la liste d'article dans le cache
            $someJeux = $jeu->getId();
            return $someJeux;
        });
            //Puis il affiche les jeux et les clients sur la page index(Accueil)
        return $this->render('home/index.html.twig', [
            'users' => $user,
            'jeuxvideo' => $jeux
        ]);
    }
}
