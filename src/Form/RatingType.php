<?php


// src/Form/RatingType.php
// src/Form/RatingExamType.php
// src/Form/RatingExamType.php

namespace App\Form;

use App\Entity\rating_exam;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course_id', null, [
                'label' => 'Course ID:',
                'attr' => ['readonly' => true], // Assuming you want to display the course ID but not allow changes
            ])
            ->add('rate_value', ChoiceType::class, [
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ],
                'label' => 'Rate the course (from 0 to 10):',
                'expanded' => true,
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => rating_exam::class,
        ]);
    }
}
