<?php

namespace App\Controller;

use App\Entity\Jeuxvideo;
use App\Entity\UploadCsv;
use App\Form\UploadCsvType;
use App\Repository\UserRepository;
use App\Repository\JeuxvideoRepository;
use Doctrine\Common\Annotations\Reader;
use Gedmo\Mapping\Annotation\Uploadable;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use League\Csv\Reader;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/accueil", name="accueil")
     */
    public function index(CacheInterface $cache, UserRepository $userRepo, JeuxvideoRepository $jeuxvideoRepo): Response
    {
        $cache = new FilesystemAdapter();
        $user = $userRepo->findAll();
        $jeux = $jeuxvideoRepo->findAll();

        for ($j=0; $j < count($jeux); $j++) { 
            $jeu = $jeux[$j];
            
        }
        $someJeux = $cache->get($jeu->getId(), function(ItemInterface $item) use ($jeu)
        {
            $someJeux = $jeu->getId();
            return $someJeux;
        });
        
        return $this->render('home/index.html.twig', [
            'users' => $user,
            'jeuxvideo' => $jeux
        ]);
    }

    /**
     * @Route("/upload", name="app_upload")
     *
     * @param Request $request
     * @return Response
     */
    public function upload(Request $request): Response
    {
        $uploader = new UploadCsv();

        $form = $this->createForm(UploadCsvType::class, $uploader);

        $form->handleRequest($request);
        //dd($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            dd($form);
        }
        

        
        //$file = fopen(__DIR__. './../../public/uploads/csv/vgsales.csv', 'r');
        //$reader = Reader::createFromPath(__DIR__. './../../public/uploads/csv/vgsales.csv', 'r');
        // while (($line = fgetcsv($file)) !== FALSE) {
        //     //$line is an array of the csv elements
        //     foreach($line as $key => $value) {
        //         echo $key . " - " . $value . "<br>";
        //     }
        // }
        //fclose($file);

        // $import;
        return $this->render('home/csv.html.twig', [
            'form' => $form->createView()
        ]);
        // return new Response('home/csv.html.twig', 200, [
        //     'Content-Encoding' => 'none',
        //     'Content-Type' => 'text/csv; charset=UTF-8',
        //     'Content-Disposition' => 'attachment; filename="name-for-your-file.csv"',
        //     'Content-Description' => 'File Transfer',
        // ]);
    }
}
