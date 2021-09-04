<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Quel nom voulez vous donner à votre adresse ?",
                'attr' => [
                    'placeholder' => "Nommer votre adresse"
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => "Quel est votre prénom ",
                'attr' => [
                    'placeholder' => "Votre Prénom"
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => "Quel est votre nom",
                'attr' => [
                    'placeholder' => "Votre nom"
                ]
            ])
            ->add('company', TextType::class, [
                'label' => "Quel est le nom de votre entreprise",
                'required' => false,
                'attr' => [
                    'placeholder' => "Le nom de votre entreprise"
                ]
            ])
            ->add('address', TextType::class, [
                'label' => "Quel est votre adresse",
                'attr' => [
                    'placeholder' => "Votre adresse"
                ]
            ])
            ->add('zip', TextType::class, [
                'label' => "Quel est votre code postal",
                'attr' => [
                    'placeholder' => "Votre code postal"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => "Quel est votre ville",
                'attr' => [
                    'placeholder' => "Votre ville"
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => "Quel est votre pays",
                'attr' => [
                    'placeholder' => "Votre pays"
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => "Quel est votre numéro de téléphone",
                'attr' => [
                    'placeholder' => "Votre numéro de téléphone"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider mon adresse ! ",
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
