<?php

namespace App\Controller;

use App\classe\Search;
use App\Form\SearchType;
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
    public function index(PresenceRepository $presenceRepository, CoursRepository $CoursRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm( SearchType::class, $search);

    
        // récupération des absents et présence dans un cours
        $present = count($presenceRepository->recupererPresent(821));

        $absent = count($presenceRepository->recupererAbsent(821));


        //POUR LE TABLEAU 
        $listeCour = $paginator->paginate(
            $CoursRepository->findBy(['user_cours' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('stat/stat.html.twig', [
            'courListe' => $listeCour,
            'presents' => $present,
            'absents' => $absent,
            'form' => $form->createView()
        ]);
    }
}