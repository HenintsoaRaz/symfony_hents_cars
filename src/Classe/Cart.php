<?php
namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart {
    public function __construct(private RequestStack $requestStack)
    {   
                
    }

    /* Fonction permettant l'ajout d'un produit au panier*/

	public function add($product)
	{   
		// dd($id); 
		// dd($product);  
		// Appeler la session de symfony
        // $cart = $this->requestStack->getSession()->get('cart'); //récupérer le panier en cours et injécté le nouvelle information 
        $cart = $this->getCart();
        // $session = $this->requestStack->getSession();
        // $this->requestStack->getSession()->set('cart', $cart); 
        // dd($session); 

		// Ajouter une quantity +1 à mon produit 
        if (isset($cart[$product->getId()])) {
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1 
            ];
        } else {
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => 1 
            ];
        }

		// Crée ma session Cart 
        $this->requestStack->getSession()->set('cart', $cart);
        // dd($this->requestStack->getSession()->get('cart', $cart));
	}

    /* decrease: Fonction permettant la suppression d'une quantity produit au panier*/

    public function decrease($id)
    {
        // $cart = $this->requestStack->getSession()->get('cart');
        $cart = $this->getCart();

        if ($cart[$id]['qty'] > 1) {
            $cart[$id]['qty'] = $cart[$id]['qty'] - 1;
        } else {
            unset($cart[$id]);
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }

    /* Fonction retournant le nombre total de produit au panier*/
    public function fullQuantity()
    {
        // $cart = $this->requestStack->getSession()->get('cart');
        $cart = $this->getCart();
        $quantity = 0;

        if (!isset($cart)) { //S. erreur vider panier
            return $quantity;
        }

        foreach ($cart as $product) {
            $quantity = $quantity + $product['qty'];
        }
        // dd($cart);
        // dd($quantity);
        return $quantity;
    }

    /* Fonction retournant le prix total des produits au panier*/
    public function getTotalWt()
    {
        // $cart = $this->requestStack->getSession()->get('cart');
        $cart = $this->getCart();
        $price = 0;

        if (!isset($cart)) { //S. erreur vider panier
            return $price;
        }

        foreach ($cart as $product) {
            $price = $price + $product['object']->getPriceWt() * $product['qty'];
        }
        return $price;
    }

    /* Fonction permettant de supprimer totalement le panier*/
    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }

    /* Fonction retournant le panier*/
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }
}