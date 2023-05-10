<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Form\CourType;
use App\Form\EleveType;
use App\Repository\CoursRepository;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveController extends AbstractController
{

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/eleve_user', name: 'app_eleve_user', methods: ['GET'])]
    public function index(EleveRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $eleves = $paginator->paginate( 
            $repository->getEleveByUser($this->getUser()),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
            'eleves' => $eleves
        ]);
    }

    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/eleve', name: 'app_eleve', methods: ['GET'])]
    public function indexAll(EleveRepository $repository, PaginatorInterface $paginator, Request $request): Response
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

    #[Security("is_granted('ROLE_ADMIN') ")]
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

    #[Security("is_granted('ROLE_ADMIN')")]
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
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/eleve/suppression/{id}', name: 'delete_eleve', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $manager, Eleve $eleve) : Response
    {

        if(!$eleve) {
            $this->addFlash(
                'success',
                "L'élève en question n'a pas été trouvé"
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

    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/eleve/affectation/{id}', name: 'app_eleve_affect', methods: ['GET', 'POST'])]
    public function affect(Eleve $eleve, EntityManagerInterface $manager, Request $request, CoursRepository $courRep): Response
    {
        $cours = $courRep->findAll();
        $form = $this->createFormBuilder()
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => function ($cours) {
                    return $cours->getLibeleeCour() . ' - ' . $cours->getUsersCours()->getNom();
                },
                'placeholder' => 'Choisir un cours',
                'label' => 'Cours',
                'attr'=>[
                    'class'=> 'form-control mr-2'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cours = $form->get('cours')->getData();
            $eleve->addCour($cours);
            $manager->flush();
            $this->addFlash('success', 'Cours affecté avec succès');
            return $this->redirectToRoute('app_eleve');
        }
        return $this->render('eleve/affect.html.twig', [
            'form' => $form->createView(),
            'eleve' => $eleve,
            'cours'=> $eleve->getCours()
        ]);
    }


}
