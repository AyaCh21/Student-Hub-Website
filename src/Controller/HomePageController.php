<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    private array $stylesheets;
    #[Route("/home", name:"homepage")]
    public function homePage(): Response
    {
        return $this->render('home.html.twig',[]);
    }

    #[Route("/profile", name:"profile")]
    public function profilePage(): Response
    {
        $this->stylesheets[]='profile.css';
        return $this->render('profile.html.twig',[
            'stylesheets'=>$this->stylesheets
        ]);
    }

}