<?php
namespace App\Controller;

use App\Classe\Mail;
use App\Form\ForgotPasswordFormType;
use App\Form\ResetPasswordFormType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ForgotPasswordController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/mot-de-passe-oublie', name: 'app_password')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
         // 1. Formulaire
         $form = $this->createForm(ForgotPasswordFormType::class);
       
         $form->handleRequest($request);
         // 2. Traitement du formulaire
         if ($form->isSubmitted() && $form->isValid()) {
             // 3. Si l'eamil renseigné par l'utilisateur est en base de donnée
            //  dd($form->getData());
            $email = $form->get('email')->getData();
            // dd($email);
            $user = $userRepository->findOneByEmail($email);
            // dd($user);

            // 4. Envoyer une notification à l'utilisateur
            $this->addFlash('success', "Si votre adresse email exisste, vous recevrez un mail pour réinitialiser votre mot de pass.");

            // 5. Si user existe, on reset le password et on envoie par email le nouveau mot de passe
            if ($user) {
                // 5 - a. Créer un token qu'on va stocker en BDD
                $token = bin2hex(random_bytes(15));
                // dd($token);
                $user->setToken($token);

                $date = new DateTime();
                // dump($date);

                $date->modify('+10 minutes');
                // dd($date);

                $user->setTokenExpireAt($date);

                $this->em->flush(); 
                // dd($user);

                $mail = new Mail();
                $vars = [
                    'link' => $this->generateUrl('app_password_update', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL),
                ];
                $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), "Modification de votre pot de passe", "forgotpassword.html", $vars);
    
            }

             // 4. Si c'est le cas, on reser le password et on envoie par email de nouveau mot de passe
             // 5. Si aucun email trouvé, on push une notification :  Email introuvable.
         } 
         
         return $this->render('password/index.html.twig', [
            'forgotPasswordForm' => $form->createView(),
         ]);
    }

    #[Route('/mot-de-passe/reset/{token}', name: 'app_password_update')]
    public function update(Request $request, UserRepository $userRepository, $token): Response
    {
        if (!$token) {
            return $this->redirectToRoute('app_password'); 
        }

        $user = $userRepository->findOneByToken($token);
        // dd($user);
        
        $now = new DateTime();
        // dump($now);
        // dump($user);
        if (!$user || $now > $user->getTokenExpireAt()) {
            return $this->redirectToRoute('app_password'); 
        }

        // die('ON EST BON');

        $form = $this->createForm(ResetPasswordFormType::class, $user);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement à effectuer
            // dd($form->getData());
            $user->setToken(null);
            $user->setTokenExpireAt(null);
            $this->em->flush();
            $this->addFlash(
                    'success',  
                    "Votre mot de passe est correctement mis à jour."
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('password/reset.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
