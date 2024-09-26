<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($options); 
        $builder
            ->add('addresses', EntityType::class, [
                'label' => "Choisissez votre adresse de livraison",
              
                'required' => true,
                'class' => Address::class,
                'expanded' => true, // Boutton radio
                'choices' => $options['addresses'],
                'label_html' => true,             
                   
                    'label_attr' => ['class' => 'your-label-classes', 'for'=>"email"],
                    'attr' => [
                        'class' => "your-field-classes",
                    ],

            ])

            ->add('carriers', EntityType::class, [
                'label' => "Choisissez votre transporteur",
                'required' => true,
                'class' => Carrier::class,
                'expanded' => true,
                'label_html' => true,

                'label_attr' => ['class' => 'your-label-classes', 'for'=>"email"],
                'attr' => [
                    'class' => "your-field-classes",
                ],
                
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'w-100 btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'addresses' => null
        ]);
    }
}
