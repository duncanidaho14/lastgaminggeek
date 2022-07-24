<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Classes\Basket;
use App\Entity\Carrier;
use App\Entity\Jeuxvideo;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Security\Core\Security as SecurityCore;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


class StripeController extends AbstractController
{

    private $entityManager;
    

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/create-session/{reference}", name="stripe_create_session")
     * 
     * I create a Stripe session with the products of the order, the shipping price and the shipping
     * name.
     * 
     * then I redirect the user to the Stripe checkout page.
     * 
     * @param Order order The order object
     * @param Basket basket the basket object
     * @param SerializerInterface serializer The serializer service.
     * @param reference the order reference
     * 
     * @return The response is a JSON object containing the following keys:
     */
    public function index(Order $order, Basket $basket, SerializerInterface $serializer, $reference)
    {
        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

        $productsStripe = [];
        $myDomaine = "https://www.gaminggeek.fr";
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
                    'unit_amount' => $product->getPrice()* 100,
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
        
    }

    /**
     * @Route("/commande/success/{stripeSessionId}", name="stripe_success")
     * 
     * It checks if the order exists and if it's paid, if not, it sets it to paid and flushes the
     * entity manager
     * 
     * @param Basket basket The basket object
     * @param stripeSessionId The ID of the Checkout Session that contains the order.
     * 
     * @return Response The order object
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
     * 
     * It gets the order from the database using the stripeSessionId, and if the order exists and the
     * user is the same as the one logged in, it renders the error page
     * 
     * @param stripeSessionId The ID of the Checkout Session that was created.
     * 
     * @return Response The order object
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
