<?php

namespace App\Controller;

use App\Entity\ProfessorRate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    private array $stylesheets;
    #[Route("/home", name:"homepage")]
    public function homePage(): Response
    {
        $this->stylesheets[]='home_header.css';
        return $this->render('home.html.twig',[
            'stylesheets'=>$this->stylesheets
        ]);
    }

    #[Route("/profile", name:"profile")]
    public function profilePage(): Response
    {
        $this->stylesheets[]='profile.css';
        return $this->render('profile.html.twig',[
            'stylesheets'=>$this->stylesheets
        ]);
    }
    /*#[Route("/rate_prof", name:"professor")]
    public function rateProfessor(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prof_rate = new professorRate();
        $form = $this->createFormBuilder()
            ->add('student', TextType::class,["attr" => array('style' => 'margin-left: 40px;')])
            ->add('professor', TextType::class, ['label' => 'Professor'])
            ->add('rate', RangeType::class, ['label' => 'Rate'])
            ->add('save', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $prof_rate = $form->getData();
            $rating = $request->request->get('rate_range');
            $prof_rate->setRate($rating);
            $prof_rate->setUploadedAt($now = new \DateTime());
            $entityManager->persist($prof_rate);
            $entityManager->flush();
            echo "Saved a new rate with id " . $prof_rate->getId();
            return $this->redirectToRoute('study');
        }

        $this->stylesheets[]='rate_form.css';
        return $this->render('rate_professor.html.twig',[
            'stylesheets'=>$this->stylesheets,
            'form' => $form
        ]);
    }*/
    //#[Route("/study", name:"study")]
    //public function study(): Response
    //{
      //  $this->stylesheets[]='study.css';
        //return $this->render('study.html.twig',[
          //  'stylesheets'=>$this->stylesheets
        //]);
    //}
}