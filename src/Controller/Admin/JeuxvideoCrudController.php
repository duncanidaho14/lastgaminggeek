<?php

namespace App\Controller\Admin;

use App\Entity\Jeuxvideo;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class JeuxvideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Jeuxvideo::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            ImageField::new('coverImage')
                ->setBasePath('uploads/')
                ->setUploadDir('public/build/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            MoneyField::new('price')->setCurrency('EUR'),
            TextEditorField::new('description'),
            AssociationField::new('user'),
            AssociationField::new('categories'),
            AssociationField::new('comments')
        ];
    }
    
}
