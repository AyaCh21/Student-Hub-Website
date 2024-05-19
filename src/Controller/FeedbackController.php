<?php
// src/Controller/FeedbackController.php
namespace App\Controller;

use App\Entity\Course;
use App\Entity\Feedback;
use App\Entity\Student;
use App\Form\FeedbackType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    #[Route('/feedback/{courseId}', name: 'feedback')]
    public function feedback($courseId, Request $request, EntityManagerInterface $entityManager, StudentRepository $studentRepository): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($courseId);
        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }

        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the provided username from the form
            $studentUsername = $form->get('studentUsername')->getData();

            // Query the Student entity based on the provided username
            $studentId = $studentRepository->findStudentIdByUsername($studentUsername);
            if (!$studentId) {
                throw $this->createNotFoundException('Student not found');
            }
            $feedback->setStudentId($studentId);

            // Set other feedback properties
            $feedback->setCourse($course);
            $feedback->setFeedback($form->get('feedback')->getData());

            $entityManager->persist($feedback);
            $entityManager->flush();

            return $this->redirectToRoute('display_professor_rate');
        }

        return $this->render('feedback.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/view_feedback/{courseId}', name: 'view_feedback')]
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
}
