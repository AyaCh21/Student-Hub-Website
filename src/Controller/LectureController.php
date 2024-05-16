<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LectureController extends AbstractController
{
    /**
     * @Route("/lecture", name="lecture")
     */
    public function lecturePage(): Response
    {
        return $this->render('lecture.html.twig');
    }
}
