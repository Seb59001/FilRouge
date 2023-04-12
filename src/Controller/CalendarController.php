<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Repository\CreneauRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function index(CreneauRepository $calendar, CoursRepository $cours, UsersRepository $user): Response
    {
        $events  = $calendar->findAll();
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

        return $this->render('calendar/index.html.twig', [
            'controller_name' => 'CalendarController',
            compact('data')
        ]);
    }
}
