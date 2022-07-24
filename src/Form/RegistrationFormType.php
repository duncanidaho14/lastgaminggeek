<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(),
                    new Email([
                        'message' => "L'email \"{{ value }}\" n'est pas valide.",
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Vôtre email'
                ]
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => 'Votre pseudo ne peut contenir moins de 5 caractères !',
                        'maxMessage' => 'Votre pseudo ne peut contenir plus de 50 caractères !'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Vôtre pseudo'
                ]
            ])
            ->add('imageFile', VichFileType::class, [
                'label' => 'Avatar',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Vôtre prénom'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => 'Votre prenom ne peut contenir moins de 5 caractères !',
                        'maxMessage' => 'Votre prenom ne peut contenir plus de 50 caractères !'
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Vôtre nom'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => 'Votre nom ne peut contenir moins de 5 caractères !',
                        'maxMessage' => 'Votre nom ne peut contenir plus de 50 caractères !'
                    ])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'répéter le mot de passe',
                'attr' => [
                    'autocomplete' => 'nouveau mot de passe',
                    'class' => [],
                    'placeholder' => "répéter le même mot de passe"                    
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Vôtre mot de passe doit au moins faire {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
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
