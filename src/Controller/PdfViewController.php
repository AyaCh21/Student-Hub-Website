<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PdfViewController extends AbstractController
{
    #[Route('/pdf/view', name: 'app_pdf_view')]
    public function index(): Response
    {
        return $this->render('pdf_view/index.html.twig', [
            'controller_name' => 'PdfViewController',
        ]);
    }
}
