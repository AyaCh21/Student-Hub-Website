<?php

namespace App\Form;

use App\Entity\Professor;
use App\Entity\ProfessorRate;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessorRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('professor', EntityType::class, [
                'class' => Professor::class,
'choice_label' => 'id',
            ])
            ->add('student', EntityType::class, [
                'class' => Student::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfessorRate::class,
        ]);
    }
}
