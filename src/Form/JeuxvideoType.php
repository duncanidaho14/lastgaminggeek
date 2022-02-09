<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Categorie;
use App\Entity\Jeuxvideo;
use App\Form\CategorieType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class JeuxvideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('imageFile', VichFileType::class)
            ->add('price', MoneyType::class)
            ->add('description', TextareaType::class)
            ->add('categories', CollectionType::class, [
                'entry_type' => CategorieType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('comments', CollectionType::class, [
                'entry_type' => CommentType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('submit', SubmitType::class)
        ;

        // $formModifier = function (FormInterface $form, Categorie $categories = null) {
        //     $choices = null === $categories ? [] : $categories->getName();

        //     $form->add('categories', EntityType::class, [
        //         'class' => Categorie::class,
        //         'choices' => $choices,
        //         'required' => false,
        //         'choice_label' => 'name',
        //         'placeholder' => 'Département (Choisir une région)',
        //         'attr' => ['class' => 'custom-select'],
        //         'label' => 'Département'
        //     ]);
        // };

        // $builder->get('categories')->addEventListener(
        //     FormEvents::POST_SUBMIT,
        //     function (FormEvent $event) use ($formModifier) {
        //         $categorie = $event->getForm()->getData();
        //         $formModifier($event->getForm()->getParent(), $categorie);
        //     }
        // );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeuxvideo::class,
        ]);
    }
}
