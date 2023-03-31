<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresenceController extends AbstractController
{
    #[Route('/presence', name: 'app_presence')]
    public function index(): Response
    {
        return $this->render('presence/presence.html.twig', [
            'controller_name' => 'Présence',
        ]);
    }
}
