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
use Symfony\Component\Routing\Attribute\Route;

class ProfessorRateController extends AbstractController
{
    #[Route("/rate_prof", name:"professor_rate")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professor_rate = new ProfessorRate();

        /*$form = $this->createFormBuilder($professor_rate)
            ->add('professor',ChoiceType::class)
            ->add('student',TextType::class)
            ->add('save',SubmitType::class,['label'=>'submit rate'])
            ->getForm();*/
        $form = $this->createForm(ProfessorRateType::class, $professor_rate);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professor_rate=$form->getData();
            $entityManager->persist($professor_rate);
            $entityManager->flush();
            echo 'Saved new rate with id ' . $professor_rate->getId();

            return $this->redirectToRoute('study');
        }

        return $this->render('rate_professor.html.twig',[
            'form_rate_prof' => $form
        ]);
    }
}