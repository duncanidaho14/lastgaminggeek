<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Choice;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //dd($options);
        $user = $options['user'];
        $carrier = $options['csrf_token_manager'];
        $builder
            ->add('addresses', EntityType::class, [
                'label' => "Choisissez vôtre adresse de livraison",
                
                'class' => Address::class,
                'choices' => $user->getAddresses(),
                'required' => true,
                //'constraints' => new Assert\Choice([$user->getAddresses()]),
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
