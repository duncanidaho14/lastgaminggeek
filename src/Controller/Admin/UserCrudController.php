<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            TextField::new('pseudo'),
            TextField::new('firstName'),
            TextField::new('lastName'),
            SlugField::new('fullName')->setTargetFieldName('firstName', 'lastName'),
            BooleanField::new('isVerified'),
            BooleanField::new('agreeTerms'),
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
            SlugField::new('slug')->setTargetFieldName('fullName'),
            AssociationField::new('grade'),
            AssociationField::new('game'),
            AssociationField::new('comments')
        ];
    }
    
}
