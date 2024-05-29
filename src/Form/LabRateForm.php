<?php

namespace App\Form;

use App\Entity\LabRate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LabRateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rateValue', RangeType::class, [
                'attr' => ['min' => 0, 'max' => 10],
                'label' => 'Rate the lab (0-10):'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Submit Rating'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LabRate::class,
        ]);
    }

}