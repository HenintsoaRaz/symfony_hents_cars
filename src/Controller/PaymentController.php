<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/commande/paiement/{id_order}', name: 'app_payment')]
    public function index($id_order, OrderRepository $orderRepository, EntityManagerInterface $entityManager): Response
    {

        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']); //$_ENV any @ .env.local
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        // $order = $orderRepository->findOneById($id_order);

        $order = $orderRepository->findOneBy([ //securiter : 127 / commande/paiement/4651449n'importe num
            'id' => $id_order,
            'user' => $this->getUser()
        ]);

        // dd($order);
        if (!$order) {
            return $this->redirectToRoute('app_home');
        }

        $products_for_stripe = [];

        foreach ($order->getOrderDetails() as $product) {
            // dd($product);
            $products_for_stripe[] = [
                'price_data' => [
                'currency' => 'eur',
                'unit_amount' => number_format($product->getProductPriceWt() * 100, 0, '', ''),
                'product_data' => [
                    'name' => $product->getProductName(),
                    'images' => [
                        $_ENV['DOMAIN'].'/uploads/'.$product->getProductIllustration() //$_ENV any @ .env.local
                    ]
                ]
            ],
                'quantity' => $product->getProductQuantity(),
            ];
        }
        // dd($order);
        // dd($id_order);
        
        // dd($products_for_stripe);
        // dd($order);
        $products_for_stripe[] = [
            'price_data' => [
            'currency' => 'eur',
            'unit_amount' => number_format($order->getCarrierPrice() * 100, 0, '', ''),
            'product_data' => [
                'name' => 'Transporteur :'.$order->getCarrierName(),
            ]
        ],
            'quantity' => 1,
        ];

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [[
                $products_for_stripe
            ]],
            'mode' => 'payment',
            // 'success_url' => $YOUR_DOMAIN . '/success.html',
            // 'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            'success_url' => $_ENV['DOMAIN'] . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $_ENV['DOMAIN'] . '/mon-panier/annulation',
        ]);

        // header("HTTP/1.1 303 See Other");
        // header("Location: " . $checkout_session->url);

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        return $this->redirect($checkout_session->url);

        // die('ok');
    }

#[Route('/commande/merci/{stripe_session_id}', name: 'app_payment_success')]
public function success($stripe_session_id, OrderRepository $orderRepository, EntityManagerInterface $entityManager, Cart $cart): Response
{
    $order = $orderRepository->findOneBy([
        'stripe_session_id' => $stripe_session_id,
        'user' => $this->getUser()
    ]);

    if (!$order) {
        return $this->redirectToRoute('app_home');
    }

    if ($order->getState() == 1) {
        $order->setState(2);
        $cart->remove();
        $entityManager->flush();
    }

    // dd($order);
    return $this->render('payment/success.html.twig', [
        'order' => $order,
    ]);
}
}

// Adresse de facturation 
// Mon panier :  supprimmer un produit   
// Ma commande : bouton vers le panier