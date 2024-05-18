<?php

namespace App\Controller;

use App\Entity\StudyMaterial;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LectureController extends AbstractController
{
    #[Route("/lecture/{id}/{type}", name: "lecture")]
    public function lecture(int $id, string $type, EntityManagerInterface $entityManager): Response
    {
        $studyMaterials = $entityManager->getRepository(StudyMaterial::class)->findBy([
            'course' => $id,
            'type' => $type
        ]);

        return $this->render('lecture.html.twig', [
            'studyMaterials' => $studyMaterials,
            'type' => ucfirst($type)  // Capitalize the first letter of the type for display
        ]);
    }
}
