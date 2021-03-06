<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('comment', TextareaType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'attr' => [
                    'class' => 'hiddentype'
                ],
                'label_attr' => [
                    'class' => 'hiddentype'
                ]
            ])
            //->add('submit', SubmitType::class) le mettre dans le fichier twig
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
