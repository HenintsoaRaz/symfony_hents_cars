<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Config\Security\PasswordHasherConfig;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class, [ //actualPassword
                'label' => "Votre mot de passe actuel",
                'attr' => [
                    'placeholder' => "Indiquez votre mot de passe actuel"
                ],
                'mapped' => false                         //Corrigé problème 
            ]) 
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 30
                    ])
                ],
                'first_options'  => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Choisissez votre nouveau mot de passe"
                    ],
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmé votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Confirmé votre nouveau mot de passe"
                    ]
                ],
                'mapped' => false, //pour forcer Symfony a n'est pas aller chercher un champ qui correspond à une entité : plainPassword any @ User.php
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Metre à jour mon mot de passe",
                'attr' => [
                    'class' => "btn btn-success"
                ]
            ])
            
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                // die('Ok MON EVENT MARCHE');
                $form = $event->getForm();
                // dd($form->getConfig()->getOptions()['data']); //intéresé par config 
                $user = $form->getConfig()->getOptions()['data'];
                // dd($user);
                // dd($form->getConfig()->getOptions()['PasswordHasher']); //+ déclarer un autre option
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher']; //+ doc/security/passwords

                    // 1. Récupérer le mot de passe saisi par l'utilisateur et le comparer au mdp en base de donnée (dans l'entité)
                    // $actualPwd = $form->get('actualPassword')->getData(); 
                    // dd($actualPwd); //azo ny password actuel
                    $isValid = $passwordHasher->isPasswordValid(
                        $user,
                        $form->get('actualPassword')->getData()
                    );
                    
                    // dd($isValid);
                    // 2. Récuérer le mot de passe actuel en BDD
                    // $actualPwdDatabase = $user->getPassword();
                    // dump($actualPwd); //password tsy crypté
                    // dd($actualPwdDatabase); //password crypté 

                    // 3. Si c'est != envoyer une erreur
                    if (!$isValid) {
                        $form->get('actualPassword')->addError(new FormError("Votre mot de pass actuel n'est pas conforme, Veuillez vérifier votre saisie."));
                    }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null
        ]);
    }
}
