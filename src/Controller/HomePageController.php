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
        $this->stylesheets[]='home_header.css';
        return $this->render('home.html.twig',[
            'stylesheets'=>$this->stylesheets
        ]);
    }

    #[Route("/about-us", name:"about-us")]
    public function aboutPage(): Response
    {
        $this->stylesheets[]='about_us.css';
        return $this->render('about_us.html.twig',[
            'stylesheets'=>$this->stylesheets
        ]);
    }

//    #[Route("/profile", name:"profile")]
//    public function profilePage(): Response
//    {
//        $this->stylesheets[]='profile.css';
//        return $this->render('profile.html.twig',[
//            'stylesheets'=>$this->stylesheets
//        ]);
//    }
    //#[Route("/study", name:"study")]
    //public function study(): Response
    //{
      //  $this->stylesheets[]='study.css';
        //return $this->render('study.html.twig',[
          //  'stylesheets'=>$this->stylesheets
        //]);
    //}
}