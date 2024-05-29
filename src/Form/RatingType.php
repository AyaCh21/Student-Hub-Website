<?php


// src/Form/RatingType.php
// src/Form/RatingExamType.php
// src/Form/RatingExamType.php

namespace App\Form;

use App\Entity\Course;
use App\Entity\ExamRate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class RatingType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

   /* public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rateValue', ChoiceType::class, [
                'choices' => array_combine(range(0, 10), range(0, 10)), // Values from 0 to 10
                'label' => 'Rate the course (from 0 to 10):',
                'expanded' => true,
                'required' => true,
            ]);
    }*/

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rateValue', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                ],
                'label' => 'Rate the course (from 0 to 10):',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExamRate::class,
        ]);
    }
}