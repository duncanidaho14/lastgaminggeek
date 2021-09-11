<?php

namespace App\Controller;

use Datetime;
use App\Entity\Order;
use DateTimeInterface;
use App\Classes\Basket;
use App\Entity\Carrier;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande", name="order")
     * @IsGranted("ROLE_USER")
     */
    public function index(Basket $basket, Request $request): Response
    {
        if(!$this->getUser()->getAddresses()->getValues()){
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
            'action' => $this->generateUrl('order_recap'),
            'method' => 'POST'
        ]);

        
        //dd($basket->getAllBasket());
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'basket' => $basket->getAllBasket()
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     * 
     * @IsGranted("ROLE_USER")
     *
     * @param Basket $data
     * @param Request $request
     * @return Response
     */
    public function add(Basket $data, Request $request): Response
    {
        
        
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
            'action' => $this->generateUrl('order_recap'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) { 
            $date = new \DateTime();
            $carriers = $form->get('carriers')->getData();
            dd($carriers);
            $delivery = $form->get('addresses')->getData();
            
            $deliveryContent = $delivery[0]->getFirstName() . ' ' . $delivery[0]->getLastName();
            $deliveryContent .= '<br />' . $delivery[0]->getPhone();

            if($delivery[0]->getCompany()){
                $deliveryContent .= '<br/>' . $delivery[0]->getCompany();
            }

            $deliveryContent .= '<br/>' . $delivery[0]->getAddress();
            $deliveryContent .= '<br/>' . $delivery[0]->getZip() . ' ' . $delivery[0]->getCity();
            $deliveryContent .= '<br/>' . $delivery[0]->getCountry();

            $order = new Order();
            $reference = $date->format('d-m-Y'). '-'.\uniqid();
            $order->setReference($reference); 
            $order->setUser($this->getUser());
            
            $order->setCarrierName($carriers[0]->getName());
            $order->setCarrierPrice(($carriers[0]->getPrice() / 100));
            $order->setDelivery($deliveryContent);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            
            
            foreach ($data->getAllBasket() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['jeuxvideo']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice(($product['jeuxvideo']->getPrice()));
                $orderDetails->setTotal(($product['jeuxvideo']->getPrice())* $product['quantity']);

                $this->entityManager->persist($orderDetails);
            }
            
            $this->entityManager->flush();
            

            return $this->render('order/add.html.twig', [
                'basket' => $data->getAllBasket(),
                'carrier' => $carriers,
                'delivery' => $deliveryContent,
                'reference' => $order->getReference()
            ]);
        }

        
        return $this->redirectToRoute('basket');
        
    }
}
