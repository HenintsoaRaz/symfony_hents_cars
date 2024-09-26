<?php

namespace App\Controller;

// use Mailjet\Client;
// use Mailjet\Resources;

use App\Classe\Mail;
use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use App\Repository\SellerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SellerRepository $sellerRepository, HeaderRepository $headerRepository, ProductRepository $productRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'sellers' => $sellerRepository->findAll(),
            'headers' => $headerRepository->findAll(),
            'productsInHomepage' => $productRepository->findByIsHomepage(true)
        ]);
    }
}