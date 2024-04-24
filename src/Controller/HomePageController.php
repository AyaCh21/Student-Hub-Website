<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    #[Route("/home", name:"homepage")]
    public function homePage(): Response
    {
        return $this->render('home.html.twig',[]);
    }

}