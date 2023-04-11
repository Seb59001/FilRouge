<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Presence;
use App\Form\PresenceType;
use App\Repository\PresenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/presence')]
class PresenceController extends AbstractController
{
    #[Route('/', name: 'app_presence', methods: ['GET'])]
    public function index(PresenceRepository $presenceRepository, PaginatorInterface $paginator, Request $request): Response
    {

        return $this->render('presence/index.html.twig', [
            'presences' => $presenceRepository=$paginator->paginate($presenceRepository->findAll(), $request->query->getInt('page',1)),10
        ]);
    }

    #[Route('/new', name: 'app_presence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PresenceRepository $presenceRepository): Response
    {
        $presence = new Presence();
        $form = $this->createForm(PresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $presenceRepository->save($presence, true);

            return $this->redirectToRoute('app_presence', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('presence/new.html.twig', [
            'presence' => $presence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presence_show', methods: ['GET'])]
    public function show(Presence $presence, Request $request, EntityManagerInterface $manager): Response
    {

        return $this->render('presence/show.html.twig', [
            'presence' => $presence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_presence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Presence $presence, PresenceRepository $presenceRepository, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $presence= $form->getData();
            $manager->persist($presence);
            $manager->flush();
            $this->addFlash(
                'success',
                "presence modifier"
            );

            return $this->redirectToRoute('app_presence');
        }

        return $this->render('presence/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_presence_delete', methods: ['POST'])]
    public function delete(EntityManagerInterface $manager, Presence $presence): Response
    {
        if(!$presence)
        {
            $this->addFlash(
                'success',
                'présence  n\'existe pas !'
            );
            return $this->redirectToRoute('app_presence');
        }

        $manager->remove($presence);
        $manager->flush();

        return $this->redirectToRoute('app_presence', [], Response::HTTP_SEE_OTHER);
    }
}
