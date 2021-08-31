<?php

namespace App\Controller;

use App\Classes\Basket;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Jeuxvideo;

class BasketController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/mon-panier", name="basket")
     */
    public function index(Basket $basket): Response
    {   
        $basketOver = [];

        foreach ($basket->get() as $id => $quantity) {
            $basketOver[] = [
                'jeuxvideo' => $this->entityManager->getRepository(Jeuxvideo::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }
        return $this->render('basket/index.html.twig', [
            'basket' => $basketOver,
        ]);
    }

    /**
     * @Route("/mon-panier/add/{id}", name="add_to_basket")
     */
    public function addToBasket(Basket $basket, $id): Response
    {
        $basket->add($id);

        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/mon-panier/remove", name="remove_to_basket")
     */
    public function remove(Basket $basket): Response
    {
        $basket->remove();

        return $this->redirectToRoute('home');
    }
}
