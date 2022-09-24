<?php

namespace App\Controller;

use App\Classes\Basket;
use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/adresse", name="account_address")
     * @Security("is_granted('ROLE_USER')")
     * 
     * The function index() returns a Response object that renders the template
     * account/address.html.twig.
     * 
     * 
     * @return Response A response object.
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig', [
            'controller_name' => 'AccountAddressController',
        ]);
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     * @Security("is_granted('ROLE_USER')")
     * 
     * If the form is submitted and valid, persist the address, flush the entity manager, and redirect
     * to the order page.
     * 
     * @param Basket basket The basket object
     * @param Request request The request object.
     * 
     * @return Response The form is being returned.
     */
    public function add(Basket $basket, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            if ($basket->get()) {
                return $this->redirectToRoute('order');
            } else {
                return $this->redirectToRoute('account_address');
            }
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_address_edit")
     * @Security("is_granted('ROLE_USER')")
     * 
     * If the address exists and belongs to the user, then create a form, handle the request, and if
     * the form is valid, flush the entity manager and redirect to the address page
     * 
     * @param Request request The request object.
     * @param id The id of the address to edit
     * 
     * @return Response The form is being returned.
     */
    public function edit(Request $request, $id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $this->entityManager->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_address_delete")
     * @Security("is_granted('ROLE_USER')")
     * 
     * If the address exists and the user is the owner of the address, then delete the address and
     * redirect to the account_address route.
     * 
     * @param id The id of the address to delete
     * 
     * @return Response A response object.
     */
    public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }
        
            return $this->redirectToRoute('account_address');
        
    }
}
