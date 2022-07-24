<?php

namespace App\Controller;

use App\Classes\Basket;
use App\Entity\Jeuxvideo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BasketController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-panier", name="basket")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(Basket $basket): Response
    {   
        
        return $this->render('basket/index.html.twig',[
            'basket' => $basket->getAllBasket(),
        ]);
        
    }

    /**
     * @Route("/mon-panier/add/{id}", name="add_to_basket")
     */
    public function addBasket(Basket $basket, $id): Response
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

        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/mon-panier/delete/{id}", name="delete_to_basket")
     */
    public function delete(Basket $basket, $id): Response
    {
        $basket->delete($id);

        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/mon-panier/decrease/{id}", name="decrease_to_basket")
     * 
     * It decreases the quantity of a product in the basket
     * 
     * @param Basket basket The basket object
     * @param id The id of the product to be removed from the basket
     * 
     * @return Response A redirect to the basket route.
     */
    public function decrease(Basket $basket, $id): Response
    {
        $basket->decrease($id);
        return $this->redirectToRoute('basket');
    }
}
