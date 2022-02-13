<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Component\HttpFoundation\RequestStack;

class Paginator
{
    private $entityClass;
    private $limit = 12;
    private $currentPage = 1;
    private $manager;

    private $twig;
    
    private $route;

    private $templatePath;

    public function __construct(EntityManagerInterface $manager, Environment $twig, RequestStack $request, $templatePath)
    {
        // la requestStack permet de connaitre le nom de la route courrante
        $this->route = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager = $manager;
        $this->twig = $twig;
        $this->templatePath = $templatePath;

    }

    public function displayPaginator()
    {
        $this->twig->display($this->templatePath, [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route
        ]);
    }
    public function getData()
    {
        if (empty($this->entityClass)) {
            throw new Exception("Vous n'avez pas indiqué l'entité sur laquelle paginer. Utilisez la méthode setEntityClass de votre objet pagination", 1);
            
        }
        // 1. calculer l'offset
        $offset = $this->currentPage * $this->limit - $this->limit;
        // 2. Demander au repository de trouver l'élément
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([], [], $this->limit, $offset);
        // 3. Renvoyez les éléments en question
        return $data;
    }

    public function getPages()
    {
        if (empty($this->entityClass)) {
            throw new Exception("Vous n'avez pas indiqué l'entité sur laquelle paginer. Utilisez la méthode setEntityClass de votre objet pagination", 1);
            
        }

        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());


        $pages = ceil($total / $this->limit);

        return $pages;
    }
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getPage()
    {
        return $this->currentPage;
    }

    public function setPage($page)
    {
        $this->currentPage = $page;
        
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }
}