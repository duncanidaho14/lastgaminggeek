<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Vôtre email'
                ]
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'placeholder' => 'Vôtre pseudo'
                ]
            ])
            // ->add('avatar', TextType::class)
            ->add('imageFile', VichFileType::class, [
                'label' => 'Avatar'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Vôtre prénom'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Vôtre nom'
                ]
            ])
            // ->add('isVerified', TextType::class)
            ->add('password', PasswordType::class, [
                'label' => 'mot de passe',
                'attr' => [
                    'placeholder' => 'Vôtre mot de passe'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'répéter le mot de passe',
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => "répéter le même mot de passe"                    
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                ])
                ->add('agreeTerms', CheckboxType::class, [
                    'mapped' => true,
                    'label' => 'Les Termes utilisateurs',
                    'constraints' => [
                        new IsTrue([
                            'message' => 'You should agree to our terms.',
                        ]),
                    ],
                ])
                ->add('submit', SubmitType::class, [
                    'label' => "S'enregistrer"
                ])
                ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
