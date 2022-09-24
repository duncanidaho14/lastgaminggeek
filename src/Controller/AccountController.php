<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends AbstractController
{

    /**
     * @Route("/compte/changer-mon-mot-de-passe", name="account_change_password")
     * @Security("is_granted('ROLE_USER')")
     * 
     * If the form is submitted and valid, we check if the old password is valid, if it is, we encode
     * the new password and persist the user.
     * 
     * @param Request request The request object.
     * @param UserPasswordEncoderInterface encoder This is the encoder service that will be used to
     * encode the password.
     * @param EntityManagerInterface manager The EntityManagerInterface instance.
     * 
     * @return Response The form is being returned.
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
     * @Route("/compte/mes-commandes/{reference}", name="account_order_show")
     * @Security("is_granted('ROLE_USER')")
     * 
     * It's a function that shows the orders of the user who is logged in.
     * 
     * @param EntityManagerInterface manager The EntityManagerInterface instance.
     * @param reference The order reference number
     */
    public function showMyOrder(EntityManagerInterface $manager, $reference): Response
    {
        $orders = $manager->getRepository(Order::class)->findOrdersSuccess($this->getUser());

        return $this->render('account/order_show.html.twig', [
            'orders' => $orders,
            
        ]);
    }

    /**
     * @Route("/compte/mes-commandes", name="account_order")
     * @Security("is_granted('ROLE_USER')")
     * 
     * It gets the orders of the current user and displays them in a table.
     * 
     * @param EntityManagerInterface manager
     * 
     * @return Response The order is being returned.
     */
    public function myOrder(EntityManagerInterface $manager): Response
    {
        $orders = $manager->getRepository(Order::class)->findOrdersSuccess($this->getUser());

        return $this->render('account/myorder.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * 
     * @Route("/compte", name="app_account")
     * @Security("is_granted('ROLE_USER')")
     * 
     * It renders the account/index.html.twig template and passes the user object to it.
     * 
     * @param UserRepository userRepo The repository class for the User entity.
     * 
     * @return Response The user object.
     */
    public function index(UserRepository $userRepo): Response
    {
        return $this->render('account/index.html.twig',[
            'user' => $userRepo->findOneBy(array('id' => $this->getUser() ))
        ]);
    }

    
}
