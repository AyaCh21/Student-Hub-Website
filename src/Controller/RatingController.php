<?php
namespace App\Controller;

use App\Entity\rating_exam;
use App\Form\RatingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/rate", name="rate_course")
     */
    public function rateCourse(Request $request): Response
    {
        $rating = new rating_exam(); // Instantiate rating_exam without constructor parameters

        $form = $this->createForm(RatingType::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the rate_value property from the form data
            $rating->setRateValue($form->get('rate_value')->getData());

            // Assuming you have access to course and student IDs
            $courseId = 1; // Replace with the actual course ID
            $studentId = 1; // Replace with the actual student ID

            // Set the course and student IDs
            $rating->setCourseId($courseId);
            $rating->setStudentId($studentId);

            // Persist the rating to the database
            $this->entityManager->persist($rating);
            $this->entityManager->flush();

            // Flash message for success
            $this->addFlash('success', 'Thank you for rating the course!');

            // Redirect to the homepage or any other page after successful submission
            return $this->redirectToRoute('homepage');
        }

        // Render the form
        return $this->render('rate_course.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
