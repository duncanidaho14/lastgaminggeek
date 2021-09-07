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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;


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
    public function index(Order $order, Basket $basket, SerializerInterface $serializer, $reference)
    {
        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

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
                    'unit_amount' => $product->getPrice(),
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
            'cancel_url' => $myDomaine . '/commande/erreur/{CHECKOUT_SESSION_ID}'
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $this->entityManager->flush();

        $response = new JsonResponse(['location' => $checkout_session->url, 'id' => $checkout_session->id]);
        return $this->redirect($checkout_session->url);
        

    //     $jsonResponse = $response->getContent();
    //     $jsonResponse = utf8_encode($jsonResponse);
    //     $results = json_decode($jsonResponse);
    //     //$jsonResp = $serializer->deserialize($jsonResponse, Order::class, 'json');
    //    // print_r($results);
    //     //return $this->json($results, 201, [], []);
    //     return $this->render('account/commande.html.twig', [
    //         'results' => $results,
    //         'basket' => $basket,
    //         'order' => $order,
    //         'location' => $response
    //     ]);
    }

    /**
     * @Route("/commande/success/{stripeSessionId}", name="stripe_success")
     */
    public function stripeSuccess(Basket $basket, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        $basket->remove();
        if (!$order->getIsPaid()) {
            $order->setIsPaid(1);
            $this->entityManager->flush();
        }
        
        return $this->render('stripe/success.html.twig', [
            'order' => $order
        ]);
    }

    /**
     * @Route("/commande/erreur/{stripeSessionId}", name="stripe_cancel")
     */
    public function stripeCancel($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('accueil');
        }
        return $this->render('stripe/erreur.html.twig', [
            'order' => $order
        ]);
    }
}
