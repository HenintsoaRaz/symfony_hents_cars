<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InvoiceController extends AbstractController
{

/*
    - Impression Facture PDF pour un utilisateur connecté
    - Vérification de la commande pour un utilisateur donné 
*/

#[Route('/compte/facture/impression/{id_order}', name: 'app_invoice_customer')]
public function printForCustomer(OrderRepository $orderRepository, $id_order): Response
{

    // reference the Dompdf namespace

// instantiate and use the dompdf class
 // 1. Vérification de l'objet commande - Existe (utilisateur)
$order = $orderRepository->findOneById($id_order);

if (!$order) {
    return $this->redirectToRoute('app_account');
}

// 2. Vérification de l'objet commande - Ok pour l'utilisateur?
if ($order->getUser() != $this->getUser()) {
    return $this->redirectToRoute('app_account');
}


$dompdf = new Dompdf();
$html = $this->renderView('invoice/index.html.twig', [
    'order' => $order
]);
$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
// $dompdf->stream();
$dompdf->stream('facture.pdf', [
   'Attachment' => false 
]);

exit();

    }

/*
    - Impression Facture PDF pour un Administrateurs connecté
    - Vérification de la commande pour un utilisateur donné 
*/

    #[Route('/admin/facture/impression/{id_order}', name: 'app_invoice_admin')]
    public function printForAdmin(OrderRepository $orderRepository, $id_order): Response
    {
    
    $order = $orderRepository->findOneById($id_order);
    
    if (!$order) {
        return $this->redirectToRoute('admin');
    }
      
    $dompdf = new Dompdf();
    $html = $this->renderView('invoice/index.html.twig', [
        'order' => $order
    ]);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('facture.pdf', [
       'Attachment' => false 
    ]);
    
    exit();
    
        }
}
