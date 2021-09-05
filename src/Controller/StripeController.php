<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Classes\Basket;
use App\Entity\Carrier;
use App\Entity\Jeuxvideo;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StripeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/commande/create-session/{reference}", name="stripe_create_session")
     */
    public function index(Basket $basket, $reference)
    {
        
        $productsStripe = [];
        $myDomaine = "http://127.0.0.1:8000";
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);
        
        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }

        

        foreach ($order->getOrderDetails()->getValues() as $product) {
            $productOrder = $this->entityManager->getRepository(Jeuxvideo::class)->findOneByName($product->getProduct());
            $productsStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => []
                    ],
                    'unit_amount' => $product->getPrice() * 100,
                ],
                'quantity' => $product->getQuantity(),
            ];
        }
        
        $productsStripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [],
                ],
                'unit_amount' => $order->getCarrierPrice() * 100,
            ],
            'quantity' => 1
        ];
        
        Stripe::setApiKey('sk_test_CfH6H673P3jKvGLZJJl48ApX');

        header('Content-Type: application/json');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'submit_type' => 'donate',
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' => ['FR', 'CA', 'US'],
            ],
            'line_items' => [[
                $productsStripe
            ]],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            'success_url' => $myDomaine . '/commande/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomaine . '/commande/cancel/{CHECKOUT_SESSION_ID}'
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $this->entityManager->flush();

        $response = new JsonResponse(['location' => $checkout_session->url, 'id' => $checkout_session->id]);
        \json_decode($response);
        return $response;
    }

    /**
     * @Route("/commande/success/{stripeSessionId}", name="stripe_success")
     */
    public function stripeSuccess($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        dd($order);
        return $this->render('stripe/success.html.twig', []);
    }

    /**
     * @Route("/commande/cancel/{stripeSessionId}", name="stripe_cancel")
     */
    public function stripeCancel($stripeSessionId): Response
    {
        return $this->render('stripe/cancel.html.twig', []);
    }
}
