<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends AbstractController
{

    /**
     * @Route("/compte/changer-mon-mot-de-passe", name="account_change_password")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $oldPwd = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $oldPwd)) {
                $newPwd = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $newPwd);
                
                $user->setPassword($password);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Votre mot de passe a été correctement mise à jour !'
                );
            }
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/mes-commandes", name="account_order")
     */
    public function myOrder(EntityManagerInterface $manager): Response
    {
        $orders = $manager->getRepository(Order::class)->findOrdersSuccess($this->getUser());

        return $this->render('account/myorder.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * Afficher le compte utilisateur
     * 
     * @Route("/compte", name="account")
     * @return Response
     */
    public function index(UserRepository $userRepo): Response
    {
        return $this->render('account/index.html.twig',[
            'user' => $userRepo
        ]);
    }

    
}
