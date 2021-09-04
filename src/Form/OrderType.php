<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('addresses', EntityType::class, [
                'label' => "Choisissez vôtre adresse de livraison",
                'required' => true,
                'class' => Address::class,
                'choices' => $user->getAddresses(),
                'multiple' => true,
                'expanded' => true
            ])
            ->add('carriers', EntityType::class, [
                'label' => "Choisissez vôtre transpoteur",
                'required' => true,
                'class' => Carrier::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Payer la commande ! ',
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}
