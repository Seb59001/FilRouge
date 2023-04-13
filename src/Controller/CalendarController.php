<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Repository\CreneauRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{



    
    #[Route('/calendar', name: 'app_calendar')]
    public function index(CreneauRepository $calendar, EntityManagerInterface $entityManager, CoursRepository $cours, UsersRepository $users): Response
    {
        $cour = $cours->findBy(['user_cours' => $this->getUser()]);
        $events  = $calendar->findBy(['appartient_cours' => $cour]);
        $creneaux = [] ;
        foreach($events as $event) {
            $creneaux[] = [
                'id' => $event->getId(),
                'start' => $event->getHeureDebut()->format('Y-m-d H:i:s'),
                'end' => $event->getHeureFin()->format('Y-m-d H:i:s'),
                'title' => $event->getAppartientCours()->getLibeleeCour(),
            ];
        }

        $data = json_encode($creneaux);

        return $this->render('calendar/index.html.twig', compact('data'));
            
    }
}
