<?php

namespace App\Form;

use App\Entity\TableReservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('timeStart', DateTimeType::class, [
                'widget'=>'single_text',
                'date_format' => 'yyyy-MM-dd HH :i',

            ])
            ->add('timeEnd', DateTimeType::class, [
                'widget'=>'single_text',
                'date_format' => 'yyyy-MM-dd HH:i',

            ])
            ->add('quantity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TableReservation::class,
        ]);
    }
}
