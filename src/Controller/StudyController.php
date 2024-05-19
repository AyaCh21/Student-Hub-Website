<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Favorite;
use App\Entity\User;
use App\Repository\CourseRepository;
use App\Repository\FavoriteRepository;
use App\Repository\FavoriteRepositoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use App\Entity\Student;
use Symfony\Bundle\SecurityBundle\Security;



class StudyController extends AbstractController
{
    private array $stylesheets;
    public function __construct(
        private Security $security,
    ){ }

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
    public function toggleFavorite(Request $request, EntityManagerInterface $entityManager, FavoriteRepository $favoriteRepository): JsonResponse
    {
        $courseId = $request->request->get('courseId');
        $course = $entityManager->getRepository(Course::class)->find($courseId);
        $user = $this->security->getUser();

        if (!$course) {
            return new JsonResponse(['status' => 'error', 'message' => 'Course not found'], 404);
        }

        $favorite = $favoriteRepository->findOneBy(['student' => $user, 'course' => $course]);

        if ($favorite) {
            $entityManager->remove($favorite);
            $entityManager->flush();
            return new JsonResponse(['status' => 'removed']);
        } else {
            $favorite = new Favorite();
            $favorite->setStudent($user);
            $favorite->setCourse($course);
            $entityManager->persist($favorite);
            $entityManager->flush();
            return new JsonResponse(['status' => 'added']);
        }
    }

    #[Route('/favorite/list', name: 'favorite_list', methods: ['GET'])]
    public function favoriteList(FavoriteRepository $favoriteRepository): JsonResponse
    {
        $user = $this->security->getUser();
        $favorites = $favoriteRepository->findBy(['student' => $user]);

        $favoriteData = array_map(function ($favorite) {
            return [
                'course' => [
                    'id' => $favorite->getCourse()->getId(),
                    'name' => $favorite->getCourse()->getName(),
                ],
            ];
        }, $favorites);

        return new JsonResponse(['favorites' => $favoriteData]);
    }

}