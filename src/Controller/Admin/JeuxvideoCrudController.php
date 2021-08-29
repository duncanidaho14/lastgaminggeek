<?php

namespace App\Controller\Admin;

use App\Entity\Jeuxvideo;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
                    ->setBasePath('uploads/images/')
                    ->setUploadDir('public/uploads/images')
                    ->setUploadedFileNamePattern('[randomhash].[extension]'),
                    //->setFormType(VichImageType::class)
                    //->setLabel('coverImage'),
                    //->setRequired(false),
            // ImageField::new('coverImage')
            //         ->setBasePath("/uploads/images")
            //         ->setUploadDir('public/build/uploads/images')
            //         ->setUploadedFileNamePattern('[randomhash].[extension]')
            //         ->setLabel('coverImage'),
            // ImageField::new('imageFile')
            // ->setBasePath('uploads/images/')
            // ->setUploadDir('public/build/uploads/images')
            // ->setFormType(VichImageType::class, [
            //     'allow_delete' => true,

            // ])
            // ->setLabel('Image'),

            // ImageField::new('coverImage')
            // ->setBasePath("/uploads/images")
            // ->setLabel('Image'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextEditorField::new('description'),
            AssociationField::new('user'),
            AssociationField::new('categories'),
            AssociationField::new('comments')
        ];
    }
    
}
