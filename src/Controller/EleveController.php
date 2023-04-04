<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/eleve/nouveau',name: 'new_eleve', methods : ['GET' , 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {

        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $eleve = $form->getData();

            $manager->persist($eleve);
        $manager->flush();

        $this->addFlash(
            'success',
            'L élève a été inscrit avec succès ! '
        );

        return $this->redirectToroute('app_eleve');
        }

        return $this->render('eleve/new.html.twig', [
             
            'form' => $form->createView()
        ]);
    }

    #[Route('/eleve/edition/{id}', name: 'edit_eleve', methods: ['GET', 'POST'])]
    public function edit(Eleve $eleve, EntityManagerInterface $manager, Request $request) : Response
    {
        
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $eleve = $form->getData();

            $manager->persist($eleve);
        $manager->flush();

        $this->addFlash(
            'success',
            'L élève a été modifié avec succès ! '
        );

        return $this->redirectToroute('app_eleve');
        }

        return $this->render('eleve/edit.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/eleve/suppression/{id}', name: 'delete_eleve', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $manager, Eleve $eleve) : Response
    {

        if(!$eleve) {
            $this->addFlash(
                'success',
                "L'ingrédient en question n'a pas été trouvé"
            );

            return $this->redirectToroute('app_eleve');
        }
        $manager->remove($eleve);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'élève a été supprimé avec succès !"
        );

        return $this->redirectToroute('app_eleve');

        
    }
}
