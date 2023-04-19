<?php

namespace App\Controller;

use App\Entity\Creneau;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/api/{id}/edit', name: 'api_event_edit', methods:['PUT'])]
    public function majEvent(?Creneau $calendar, Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $donnees = json_decode($request->getContent());

        if (
            isset($donnees->id) && !empty($donnees->id) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->end) && !empty($donnees->end) &&
            isset($donnees->title) && !empty($donnees->title)
        ){
            $code = 200;

            if(!$calendar){
                $calendar = new Creneau;

                $code = 201;
            }
            $calendar->getId();
            $calendar->getAppartientCours()->setLibeleeCour($donnees->title);
            $calendar->setHeureDebut(new DateTime($donnees->start));
            $calendar->setHeureFin(new DateTime($donnees->end));

            $em = $doctrine->getManager();
            $em->persist($calendar);
            $em->flush();

            return new Response('Ok', $code);
        }else{
            return new Response('Données incomplètes', 404);
        }
         
        // return $this->render('api/index.html.twig', [
        //     'controller_name' => 'ApiController',
        // ]);
    }
}
