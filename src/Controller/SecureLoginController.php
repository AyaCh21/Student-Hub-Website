<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecureLoginController extends AbstractController
{
    #[Route("/login", name:"loginPage")]
    public function loginPage(): Response
    {
        return $this->render('login.html.twig');
    }
}