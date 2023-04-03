<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveController extends AbstractController
{
    #[Route('/eleve', name: 'app_eleve', methods: ['GET'])]
    public function index(EleveRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $eleves = $paginator->paginate( 
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
            'eleves' => $eleves
        ]);
    }

    #[Route('/eleve/nouveau', 'eleve.new', methods : ['GET' , 'POST'])]
    public function new() : Response
    {

        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);

        return $this->render('eleve/new.html.twig', [
             
            'form' => $form->createView()
        ]);
    }
}
