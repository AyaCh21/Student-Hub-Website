<?php
// src/Form/FeedbackType.php
namespace App\Form;

use App\Entity\ProfessorRate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessorRateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('studentUsername', TextType::class, [
                'label' => 'Your Username',
                'required' => true,
            ])
            ->add('rate',RangeType::class,[
                'attr' => ['min' => 0, 'max' => 10],
                'label' => 'choose the rate:'
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Submit rate'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfessorRate::class,
        ]);
    }
}