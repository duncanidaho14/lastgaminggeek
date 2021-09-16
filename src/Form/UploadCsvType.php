<?php

namespace App\Form;

use App\Entity\UploadCsv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class UploadCsvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rank', IntegerType::class)
            ->add('name', TextType::class)
            ->add('platform', TextType::class)
            ->add('year', DateTimeType::class)
            ->add('genre', TextType::class)
            ->add('publisher', TextType::class)
            ->add('naSales', MoneyType::class)
            ->add('euSales', MoneyType::class)
            ->add('jpSales', MoneyType::class)
            ->add('otherSales', MoneyType::class)
            ->add('globalSales', MoneyType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UploadCsv::class,
        ]);
    }
}
