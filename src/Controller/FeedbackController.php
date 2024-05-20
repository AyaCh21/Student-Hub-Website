<?php
// src/Controller/FeedbackController.php
namespace App\Controller;

use App\Entity\Course;
use App\Entity\Feedback;
use App\Entity\Feedbackprof;
use App\Entity\Professor;
use App\Entity\Student;
use App\Form\FeedbackTypeC;
use App\Form\FeedbackType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    #[Route('/feedbacks/{courseId}', name: 'feedback_course')]
    public function feedback($courseId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($courseId);
        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }

        $feedback = new Feedback();
        $form = $this->createForm(FeedbackTypeC::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the provided username from the form
            $studentUsername = $form->get('studentUsername')->getData();

            // Query the Student entity based on the provided username
            $student = $entityManager->getRepository(Student::class)->findOneBy(['username' => $studentUsername]);
            if (!$student) {
                throw $this->createNotFoundException('Student not found');
            }

            // Set the student entity and other feedback properties
            $feedback->setStudent($student);
            $feedback->setCourse($course);
            $feedback->setFeedback($form->get('feedback')->getData());

            // Persist and flush the feedback entity
            $entityManager->persist($feedback);
            $entityManager->flush();


        }

        return $this->render('feedback.html.twig', [
            'form_course' => $form->createView(),
        ]);
    }

    #[Route('/view/{courseId}', name: 'view')]
    public function viewFeedback($courseId, EntityManagerInterface $entityManager): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($courseId);
        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }

        $feedbacks = $entityManager->getRepository(Feedback::class)->findBy(['course' => $course]);

        return $this->render('view_feedback.html.twig', [
            'course' => $course,
            'feedbacks' => $feedbacks
        ]);
    }
    #[Route('/feedback/{professorId}', name: 'feedback_prof')]
    public function feedbackprof(int $professorId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $professor = $entityManager->getRepository(Professor::class)->find($professorId);
        $feedback = new Feedbackprof();
        if (!$professor) {
            throw $this->createNotFoundException('Professor not found');
        }


        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentUsername = $form->get('studentUsername')->getData();
            $student = $entityManager->getRepository(Student::class)->findOneBy(['username' => $studentUsername]);
            if (!$student) {
                throw $this->createNotFoundException('Student not found');
            }

            //  $course = $form->get('course')->getData();
            // $feedback->setCourse($course);
            $feedback->setStudent($student);
            $feedback->setProfessor($professor);
            $feedback->setFeedback($form->get('feedback')->getData());
            $entityManager->persist($feedback);
            $entityManager->flush();

            return $this->redirectToRoute('display_professor_rate');
        }

        return $this->render('feedbackprof.html.twig', [
            'professor' => $professor,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/view_feedback/{professorId}', name: 'view_feedback')]
    public function viewFeedbacks(int $professorId, EntityManagerInterface $entityManager): Response
    {
        $professor = $entityManager->getRepository(Professor::class)->find($professorId);
        if (!$professor) {
            throw $this->createNotFoundException('Professor not found');
        }

        $professorFeedbacks = $entityManager->getRepository(Feedbackprof::class)->findBy(['professor' => $professor]);

        return $this->render('view_feedbackprof.html.twig', [
            'professor' => $professor,
            'professorFeedbacks' => $professorFeedbacks,
        ]);
    }

}
