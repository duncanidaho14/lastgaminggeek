<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ImageField::new('image')
                ->setBasePath('uploads/categories')
                ->setUploadDir('public/uploads/categories')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextField::new('imageFile')
                    ->setFormType(VichImageType::class)
                    ->onlyWhenCreating(),
            AssociationField::new('game')
        ];
    }
    
}
