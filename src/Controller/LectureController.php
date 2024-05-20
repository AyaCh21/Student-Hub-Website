<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\StudyMaterial;
use App\Entity\Comment;
use App\Form\CommentForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LectureController extends AbstractController
{
    #[Route("/lecture/{id}/{type}", name: "lecture")]
    public function lecture(int $id, string $type, EntityManagerInterface $entityManager,Request $request): Response
    {
        // Fetch the course name
        $course = $entityManager->getRepository(Course::class)->find($id);
        $courseName = $course ? $course->getName() : 'Unknown Course';

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

        $comment = new Comment();
        $form = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCourseId($id);
            $comment->setUserId($this->getUser()->getId());
            $comment->setType($type);
            $comment->setCreatedAt(new \DateTime());
            $comment->setUpdatedAt(new \DateTime());

            //this art is if the comment is a reply to another comment:
            // Check if the comment is a reply to a top-level comment
            $parentId = $request->request->get('parent_id');
            if ($parentId) {
                $parentComment = $entityManager->getRepository(Comment::class)->find($parentId);
                if ($parentComment && $parentComment->getParent() === null) {
                    $comment->setParent($parentComment);
                } else {
                    // Handle the case where the parent comment is not top-level
                    throw new \Exception('You can only reply to top-level comments.');
                }
            }



            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('lecture', ['id' => $id, 'type' => $type]);
        }

        return $this->render('lecture.html.twig', [
            'studyMaterials' => $studyMaterials,
            'type' => ucfirst($type),  // Capitalize the first letter of the type for display
            'courseName' => $courseName,  // Pass the course name to the template
            'comments' => $comments,
            'commentForm' => $form->createView(),
            'stylesheets' => $this->stylesheets
        ]);
    }
}
