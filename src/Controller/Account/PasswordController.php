<?php

namespace App\Controller\Account;

use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    // public function password(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response //atao any @ PasswordUserType ny traitement + Rehefa hitan'ny Bd fa diso ny Password nampidirinao t@ modif password dia maniparam mitovy @ Register Controller
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response //atao any @ PasswordUserType ny traitement + Rehefa hitan'ny Bd fa diso ny Password nampidirinao t@ modif password dia maniparam mitovy @ Register Controller
    {
        
        $user = $this->getUser();
        // dd($user); //hita daholo ny conf user
        
        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordHasher' => $passwordHasher //doc/The Basics->form->Passing Options to Forms 
        ]);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $this->$entityManager->flush();
            $this->addFlash(
                    'success',  
                    "Votre mot de passe est correctement mis à jour."
            );
        }

        return $this->render('account/password/index.html.twig', [
            'modifyPwd' => $form->createView()
        ]); 
    }
}
?>