<?php
// src/Form/FeedbackType.php
namespace App\Form;


use App\Entity\Feedbackprof;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('studentUsername', TextType::class, [
                'label' => 'Your Username',
                'required' => true,
            ])
            ->add('feedback', TextareaType::class, [
                'label' => 'Your Feedback'
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Submit Feedback'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedbackprof::class,
        ]);
    }
}
