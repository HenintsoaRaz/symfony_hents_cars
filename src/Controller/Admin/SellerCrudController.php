<?php

namespace App\Controller\Admin;

use App\Entity\Seller;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SellerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Seller::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        $required = true;
		if ($pageName == 'edit') {
			$required = false;
		}

        return [
            TextField::new('title', 'Titre'),
            TextareaField::new('content', 'Contenu'),
            TextField::new('descriptionSeller', 'Titre du bouton'),
            TextareaField::new('buttonSeller', 'URL du bouton'),
            ImageField::new('illustration')
                ->setLabel('Image de fond  ')
                ->setHelp('Image de fond d')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setBasePath('/uploads')
                ->setUploadDir('/public/uploads')
                ->setRequired($required),
        ];
    }
    
}
