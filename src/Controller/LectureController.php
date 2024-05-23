<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\StudyMaterial;
use App\Entity\Comment;
use App\Entity\Professor;
use App\Entity\rating_exam;
use App\Form\CommentForm;
use App\Form\ReplyForm;
use App\Form\RatingType;
use App\Repository\RatingExamRepository;
use App\Repository\ProfessorRateRepository;
use App\Repository\ProfessorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class LectureController extends AbstractController
{
    #[Route("/lecture/{id}/{type}", name: "lecture")]
    public function lecture(int $id, string $type, EntityManagerInterface $entityManager,Request $request, RatingExamRepository $ratingExamRepository, ProfessorRateRepository $professorRateRepository,
                            ProfessorRepository $professorRepository): Response
    {
        // Fetch the course name
        $course = $entityManager->getRepository(Course::class)->find($id);
        $courseName = $course ? $course->getName() : 'Unknown Course';

        // Fetch professor based on course ID
        $professor = $professorRepository->findProfessorByCourseId($id);
        $professorName = $professor ? $professor->getName() : 'Unknown Professor';
        // Fetch average professor rating
        $averageProfessorRating = $professor ? $professorRateRepository->getAverageRatingForProfessor($professor->getId()) : null;



        $studyMaterials = $entityManager->getRepository(StudyMaterial::class)->findBy([
            'course' => $id,
            'type' => $type
        ]);

//        here the correct comments are gotten, it includes the replies to those comments (their children)
        $comments = $entityManager->getRepository(Comment::class)->findBy([
            'course_id' => $id,
            'type' => $type,
        ]);

        $this->stylesheets[]='lecture.css';
        $this->javascripts[] = 'lecture.js';

        $comment = new Comment();
        $commentForm = $this->createForm(CommentForm::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCourseId($id);
            $comment->setUserId($this->getUser()->getId());
            $comment->setType($type);
            $comment->setCreatedAt(new \DateTime());
            $comment->setUpdatedAt(new \DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('lecture', ['id' => $id, 'type' => $type]);
        }

        $replyComment = new Comment();
        $replyForm = $this->createForm(ReplyForm::class, $comment);
        $replyForm->handleRequest($request);

        // Handle the reply form submission
        if ($replyForm->isSubmitted() && $replyForm->isValid()) {
            $replyComment->setCourseId($id);
            $replyComment->setUserId($this->getUser()->getId());
            $replyComment->setType($type);
            $replyComment->setCreatedAt(new \DateTime());
            $replyComment->setUpdatedAt(new \DateTime());

            // Set parent for reply
            $parentId = $request->request->get('parent_id');
            if ($parentId) {
                $parentComment = $entityManager->getRepository(Comment::class)->find($parentId);
                if ($parentComment) {
                    $replyComment->setParent($parentComment);
                }
            }

            $entityManager->persist($replyComment);
            $entityManager->flush();

            return $this->redirectToRoute('lecture', ['id' => $id, 'type' => $type]);
        }


        // Fetch average course rating (this is actual an exam rating)
        $averageCourseRating = $ratingExamRepository->getAverageRatingForCourse($id);

        // Fetch average professor rating
        //$averageProfessorRating = $professor ? $professorRateRepository->getAverageRatingForProfessor($professor->getId()) : null;


        return $this->render('lecture.html.twig', [
            'studyMaterials' => $studyMaterials,
            'type' => ucfirst($type),  // Capitalize the first letter of the type for display
            'courseName' => $courseName,  // Pass the course name to the template
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),
            'replyForm' => $replyForm->createView(),
            'stylesheets' => $this->stylesheets,
            'javascripts' => $this->javascripts,
            'averageCourseRating' => $averageCourseRating,
            'averageProfessorRating' => $averageProfessorRating,
            'professorName' => $professorName
        ]);
    }
}
