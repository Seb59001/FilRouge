<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CourController extends AbstractController
{
    #[Route('/cour', name: 'app_cour')]
    public function index(CoursRepository $repository): Response
    {
        $listeCour= $repository->findAll();
        
        return $this->render('cour/cour.html.twig', [
            'controller_name' => 'Cours',
            'courListe'=>$listeCour
        ]);
    }
}
