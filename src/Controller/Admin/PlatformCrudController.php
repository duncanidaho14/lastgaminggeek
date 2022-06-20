<?php

namespace App\Controller\Admin;

use App\Entity\Platform;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlatformCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Platform::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ImageField::new('image')
                    ->setBasePath('uploads/platform/')
                    ->setUploadDir('public/uploads/platform')
                    ->setUploadedFileNamePattern('[randomhash].[extension]')
                    ->onlyOnIndex(),
            TextField::new('imageFile')
                    ->setFormType(VichImageType::class)
                    ->onlyWhenCreating(),
            
            //AssociationField::new('game')
        ];
    }
    
}
