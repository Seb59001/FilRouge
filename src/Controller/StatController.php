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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatController extends AbstractController
{

    #[Security ("is_granted('ROLE_USER')")]
    #[Route('/stat', name: 'app_stat')]
    public function index(PresenceRepository $presenceRepository, CoursRepository $CoursRepository, PaginatorInterface $paginator, Request $request): Response
    {

        // Initialisation des variables
        $absent = 0;
        $present = 0;

        // Création d'une instance de la classe Search et d'un formulaire associé
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des checkbox cochées
            $checkbox = $search->cours;
            // Pour chaque checkbox cochée, récupération de l'ID du cours associé
            for ($i = 0; $i < sizeof($checkbox); $i++) {
                $idCours[$i] = $checkbox[$i]->getId();
                // Récupération du nombre de présences pour le cours associé à l'ID
                $compte = count($presenceRepository->recupererPresent($idCours[$i]));
                // Ajout du nombre de présences au total des présences
                $present = $present + $compte;
            }
        }

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des checkbox cochées
            $checkbox = $search->cours;
            // Pour chaque checkbox cochée, récupération de l'ID du cours associé
            for ($i = 0; $i < sizeof($checkbox); $i++) {
                $idCours[$i] = $checkbox[$i]->getId();
                // Récupération du nombre d'absences pour le cours associé à l'ID
                $compte = count($presenceRepository->recupererAbsent($idCours[$i]));
                // Ajout du nombre d'absences au total des absences
                $absent = $absent + $compte;
            }
        }




        // Affichage de la vue 'stat.html.twig' avec les variables nécessaires
        return $this->render('stat/stat.html.twig', [
            
            'presents' => $present,
            'absents' => $absent,
            'form' => $form->createView(),
        ]);
    }
}




