<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Repository\PresenceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatController extends AbstractController
{

    #[Route('/stat', name: 'app_stat')]
    public function index(PresenceRepository $presenceRepository,CoursRepository $CoursRepository, PaginatorInterface $paginator, Request $request): Response
    {
        //POUR LE CERCLE 

$presents =count( $presenceRepository->findBy([
    'present' => "1"
]));

$absents =count( $presenceRepository->findBy([
    'present' => "0"
]));



        //POUR LE TABLEAU 
        $listeCour = $paginator->paginate(
            $CoursRepository->findBy(['user_cours' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('stat/stat.html.twig', [          
            'courListe' => $listeCour,
            'presents' => $presents,
            'absents' => $absents
        ]);
    }
}
