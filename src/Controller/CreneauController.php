<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreneauController extends AbstractController
{
    #[Route('/creneau', name: 'app_creneau')]
    public function index(): Response
    {
        return $this->render('creneau/index.html.twig', [
            'controller_name' => 'CreneauController',
        ]);
    }
}
