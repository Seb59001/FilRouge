<?php

namespace App\Controller;

use App\Entity\Creneau;
use App\Form\CreneauType;
use App\Repository\CreneauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreneauController extends AbstractController
{
    #[Route('/creneau', name: 'app_creneau', methods:['GET'])]
    public function index(CreneauRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $creneaux = $paginator->paginate( 
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('creneau/index.html.twig', [
            'controller_name' => 'CreneauController',
            'creneaux' => $creneaux
        ]);
    }

    #[Route('/creneau/nouveau', name: 'new_creneau', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {

        $creneau = new Creneau();
        $form = $this->createForm(CreneauType::class, $creneau);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $creneau = $form->getData();

            $manager->persist($creneau);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le créneau a été inséré avec succès ! '
        );

        return $this->redirectToroute('app_creneau');
        }
        return $this->render('creneau/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/creneau/edition/{id}', name: 'edit_creneau', methods: ['GET', 'POST'])]
    public function edit(Creneau $creneau, EntityManagerInterface $manager, Request $request) : Response
    {
        
        $form = $this->createForm(CreneauType::class, $creneau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $creneau = $form->getData();

            $manager->persist($creneau);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le créneau a été modifié avec succès ! '
        );

        return $this->redirectToroute('app_creneau');
        }

        return $this->render('creneau/edit.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/creneau/suppression/{id}', name: 'delete_creneau', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $manager, Creneau $creneau) : Response
    {

        if(!$creneau) {
            $this->addFlash(
                'success',
                "Le créneau en question n'a pas été trouvé"
            );

            return $this->redirectToroute('app_creneau');
        }
        $manager->remove($creneau);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le créneau a été supprimé avec succès !"
        );

        return $this->redirectToroute('app_creneau');

        
    }
}
