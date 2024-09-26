<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response 
    { 
        // dd($request);
        $user = new User();

        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // die('FORMULAIRE SOUMIS');
            // dd($form->getData());
            // dd($user);

            $entityManager->persist($user); //perstit: mamorona user
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Votre compte est correctement crée. Veuillez vous connecter"
            );

            // Envoie d'un email de confirmation d'inscription 
            $mail = new Mail();
            // $content = "Bonjour <br/> J'espère que vous allez bien (test balise HTML).";
            $vars = [
                'firstname' => $user->getFirstname()
            ];
            $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), "Bienvenue sur la boutique Française", "welcome.html", $vars);
     
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}