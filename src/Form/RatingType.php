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

class RatingType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Fetch the courses from the database
        $courses = $this->entityManager->getRepository(Course::class)->findAll();

        // Extract course names
        $courseChoices = [];
        foreach ($courses as $course) {
            $courseChoices[$course->getName()] = $course->getId();
        }
        $builder
            ->add('course_id', ChoiceType::class, [
                'label' => 'Course:',
                'choices' => $courseChoices, // Populate dropdown with course names
                'attr' => ['readonly' => true], // display the course ID but not allow changes
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
    }*/

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rateValue', ChoiceType::class, [
                'choices' => array_combine(range(0, 10), range(0, 10)), // Values from 0 to 10
                'label' => 'Rate the course (from 0 to 10):',
                'expanded' => true,
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