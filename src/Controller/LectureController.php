<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\StudyMaterial;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LectureController extends AbstractController
{
    private array $stylesheets = [];

    /**
     * @Route("/lecture", name="lecture")
     */
    #[Route("/lecture", name:"lecture")]
    public function lecture(EntityManagerInterface $entityManager): Response
    {
        $studyMaterials = $entityManager->getRepository(StudyMaterial::class)->findAll();
        $typeWiseMaterials = [];

        foreach ($studyMaterials as $material) {
            $type = $material->getType();
            if (!isset($typeWiseMaterials[$type])) {
                $typeWiseMaterials[$type] = [];
            }
            $typeWiseMaterials[$type][] = $material;
        }

        $this->stylesheets[] = 'lecture.css';

        return $this->render('lecture.html.twig', [
            'stylesheets' => $this->stylesheets,
            'typeWiseMaterials' => $typeWiseMaterials
        ]);
    }
}