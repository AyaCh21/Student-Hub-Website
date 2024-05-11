<?php

namespace App\Controller;

use App\Entity\Professor;
use App\Entity\ProfessorRate;
use App\Form\ProfessorRateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfessorRateController extends AbstractController
{
    public function new(Request $request): Response
    {
        $professor_rate = new ProfessorRate();

        /*$form = $this->createFormBuilder($professor_rate)
            ->add('professor',ChoiceType::class)
            ->add('student',TextType::class)
            ->add('save',SubmitType::class,['label'=>'submit rate'])
            ->getForm();*/
        $form = $this->createForm(ProfessorRateType::class, $professor_rate);

        return $this->render('rate_professor.html.twig',[
            'form' => $form
        ]);
    }
}