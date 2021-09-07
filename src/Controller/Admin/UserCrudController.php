<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

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
            BooleanField::new('isVerified'),
            BooleanField::new('agreeTerms'),
            ImageField::new('avatar')
                ->setBasePath('uploads/user')
                ->setUploadDir('public/uploads/user/')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextField::new('imageFile')
                ->setFormType(VichImageType::class),
            DateField::new('createdAt'),
            DateField::new('updatedAt'),
            SlugField::new('slug')
                ->setTargetFieldName('firstName', 'lastName')
                ->hideOnIndex(),
            // AssociationField::new('grade'),
            // AssociationField::new('game'),
            // AssociationField::new('comments')
        ];
    }

    // protected function persistUserEntity($user)
    // {
    //     $encodedPassword = $this->encodePassword($user, $user->getPlainPassword());
    //     $user->setPassword($encodedPassword);

    //     parent::persistEntity($user);
    // }

    // protected function updateUserEntity($user)
    // {
    //     $encodedPassword = $this->encodePassword($user, $user->getPlainPassword());
    //     $user->setPassword($encodedPassword);

    //     parent::updateEntity($user);
    // }

    // private function encodePassword($user, $password)
    // {
    //     $passwordEncoderFactory = new EncoderFactory([
    //         User::class => new MessageDigestPasswordEncoder('sha512', true, 5000)
    //     ]);

    //     $encoder = $passwordEncoderFactory->getEncoder($user);

    //     return $encoder->encodePassword($password, $user->getSalt());
    // }
    
}
