<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Favorite;
use App\Repository\CourseRepository;
use App\Repository\FavoriteRepositoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class StudyController extends AbstractController
{
    private array $stylesheets;
    /**
     * @Route("/study", name="study")
     */
    #[Route("/study", name:"study")]
    public function study(EntityManagerInterface $entityManager): Response
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();
        $phaseWiseCourses = [];

        foreach ($courses as $course) {
            $phase = $course->getPhase();
            if (!isset($phaseWiseCourses[$phase])) {
                $phaseWiseCourses[$phase] = [];
            }
            $phaseWiseCourses[$phase][] = $course;
        }
        $this->stylesheets[]='study.css';

        return $this->render('study.html.twig', [
            'stylesheets' => $this->stylesheets,
            'phaseWiseCourses' => $phaseWiseCourses
        ]);
    }

    #[Route("/favorite/toggle", name: "favorite_toggle", methods: ["POST"])]
    public function toggleFavorite(Request $request, EntityManagerInterface $entityManager, FavoriteRepository $favoriteRepository, UserInterface $user): JsonResponse
    {
        $courseId = $request->request->get('courseId');
        $course = $entityManager->getRepository(Course::class)->find($courseId);

        if (!$course) {
            return new JsonResponse(['status' => 'error', 'message' => 'Course not found'], 404);
        }

        $favorite = $favoriteRepository->findOneBy(['user' => $user, 'course' => $course]);

        if ($favorite) {
            $entityManager->remove($favorite);
            $entityManager->flush();
            return new JsonResponse(['status' => 'removed']);
        } else {
            $favorite = new Favorite();
            $favorite->setUser($user);
            $favorite->setCourse($course);
            $entityManager->persist($favorite);
            $entityManager->flush();
            return new JsonResponse(['status' => 'added']);
        }
    }



}