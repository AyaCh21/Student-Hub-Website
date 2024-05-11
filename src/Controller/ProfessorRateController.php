<?php

namespace App\Controller;

use App\Entity\Professor;
use App\Entity\ProfessorRate;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfessorRateController extends AbstractController
{
    #[Route("/rate_prof", name:"professor_rate")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professor_rate = new ProfessorRate();
        $professors = $entityManager->getRepository(Professor::class)->findAll();

        $form = $this->createFormBuilder($professor_rate)
            ->add('professor',ChoiceType::class,[
                'choices'=>$professors,
                'choice_label'=>function (Professor $professor) {
                    return $professor->getName(); // Assuming getName() exists
                },
            ])
            ->add('student', TextType::class)
            ->add('rate',IntegerType::class)
            ->add('save',SubmitType::class,['label'=>'submit rate'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $studentId = $form->get('student')->getData();
            $student = $entityManager->getRepository(Student::class)->findOneBy($studentId);
            if ($student) {
                $professor_rate->setStudent($student);
            } else {
                return $this->redirectToRoute('professor_rate', ['error' => 'Invalid student ID']);
            }
            $entityManager->persist($professor_rate);
            $entityManager->flush();
            //echo 'Saved new rate with id ' . $professor_rate->getId();

            return $this->redirectToRoute('study');
        }

        return $this->render('rate_professor.html.twig',[
            'form_rate_prof' => $form,
        ]);
    }
}