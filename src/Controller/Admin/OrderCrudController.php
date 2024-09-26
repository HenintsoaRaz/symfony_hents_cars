<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Classe\State;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class OrderCrudController extends AbstractCrudController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes')
        ;
    }

public function configureActions(Actions $actions): Actions
{
    $show = Action::new('Afficher')->linkToCrudAction('show');
    return $actions
        ->add(Crud::PAGE_INDEX, $show) 
        ->remove(Crud::PAGE_INDEX, Action::NEW)
        ->remove(Crud::PAGE_INDEX, Action::EDIT)
        ->remove(Crud::PAGE_INDEX, Action::DELETE);
}

// Fonction permettant le changement de statut de commande 
public function changeState($order, $state)
{
        //  dd(State::STATE[$state]);
    // dd($state);
    // 1.Modification du statut de la commande
    $order->setState($state);
    $this->em->flush();

    // 2.Affichage du flash Message pour informer l'administrateur 
    $this->addFlash('success', "Statut de la commande correctement mis à jour.");

    // 3. Informer l'utilisateur par mail de la modification du statut de sa commande
    // dd($order->getUser()->getEmail());
    // $to = $order->getUser()->getEmail();
    // if ($state == 3) {
    //     $object = "Commande en cours de préparation";
    // }


    $mail = new Mail();
    // dd($mail);
    $vars = [
        'firstname' => $order->getUser()->getFirstname(),
        'id_order' => $order->getId()
    ];
    $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname().' '.$order->getUser()->getLastname(), State::STATE[$state]['email_subject'], State::STATE[$state]['email_template'], $vars);

}

public function show(AdminContext $context, AdminUrlGenerator $adminUrlGenerator, Request $request)
{
    $order = $context->getEntity()->getInstance();
    // dd($order);

    // Récupérer l'URL de notre action "SHOW"
    $url = $adminUrlGenerator->setController(self::class)->setAction('show')->setEntityId($order->getId())->generateUrl();
    // dd($url);

    // Traitement des changements de statut
    // dd($request->get('state'));

    if ($request->get('state')) {
        $this->changeState($order, $request->get('state')); 
    }


    return $this->render('admin/order.html.twig', [
        'order' => $order,
        'current_url' => $url
    ]); 
}
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('createdAt')->setLabel('Date'),
            NumberField::new('state')->setLabel('Statut')->setTemplatePath('admin/state.html.twig'),
            AssociationField::new('user')->setLabel('Utilisateur'),
            TextField::new('carrierName')->setLabel('Transporteur'),
            NumberField::new('totalTva')->setLabel('Total TVA'),
            NumberField::new('totalWt')->setLabel('Total TTC')
        ];
    }

}
