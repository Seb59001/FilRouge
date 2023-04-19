<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/home', name:"home", methods:['GET', 'POST'])]
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/', name:"app_home")]
    public function index(): Response
    {
        return $this->redirectToRoute('home', [
            'controller_name' => 'HomeController'
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name:"adminHome", methods:['GET', 'POST'])]
    public function indexAdmin(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
