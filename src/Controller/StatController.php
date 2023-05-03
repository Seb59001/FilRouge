<?php

namespace App\Controller;

use App\classe\Search;
use App\Form\SearchType;
use App\Repository\CoursRepository;
use App\Repository\PresenceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatController extends AbstractController
{

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/stat', name: 'app_stat')]
    public function index(PresenceRepository $presenceRepository, Request $request): Response
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
        return $this->render('stat/.html.twig', [

            'presents' => $present,
            'absents' => $absent,
            'form' => $form->createView(),
        ]);
    }




    #[Route('/graph', name: 'graph')]
    public function graph(PresenceRepository $presenceRepository, Request $request, CoursRepository $coursRepository): Response
    {
       
          // Initialisation des compteurs
    $absent = 0;
    $present = 0;
    
    // Récupération de tous les cours
    $cours = $coursRepository->findAll();
    
    // Récupération des cours sélectionnés
    $idCours = [];
    $idCours = $request->get('cours');
    
    // Calcul du nombre de présents pour chaque cours sélectionné
    if ($idCours != null) {
       
    for ($i = 0; $i < sizeof($idCours); $i++) {
        $compte = count($presenceRepository->recupererPresent($idCours[$i]));
        $present = $present + $compte;
    }
     
    // Calcul du nombre d'absents pour chaque cours sélectionné
    for ($i = 0; $i < sizeof($idCours); $i++) {
        $compte = count($presenceRepository->recupererAbsent($idCours[$i]));
        $absent = $absent + $compte;
    }
    }
    // Si la requête est effectuée en AJAX, retourne la réponse en JSON
    if ($request->isXmlHttpRequest()) {
        $data = [
            'present' => $present,
            'absent' => $absent,
        ];
        return new JsonResponse($data);
    }
    
    // Sinon, retourne la réponse en HTML
    return $this->render('stat/graph.html.twig', [
        'cours' => $cours,
       
    ]);
}
}
