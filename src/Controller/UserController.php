<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user' , methods:'GET')]
    public function listeUser(): Response
    {







        
        return $this->render('user/user.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
