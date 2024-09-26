<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produit/{slug}', 'app_product')]
    public function index($slug, ProductRepository $productRepository): Response
    // DEUXIEME METHODE : // public function index(#[MapEntity('slug')] Product $product): Response
    {
        // dd($slug);
        $product = $productRepository->findOneBySlug($slug);
        // dd($product); 

        if(!$product) {
			return $this->redirectToRoute('app_home'); //alefa any @ app_home izay produit tsy misy tapena @ lien
		}

        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }
}
