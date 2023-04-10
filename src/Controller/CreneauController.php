<?php

namespace App\Controller;

use App\Entity\Creneau;
use App\Form\CreneauType;
use App\Repository\CoursRepository;
use App\Repository\CreneauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class CreneauController extends AbstractController
{
    /**
     *
     * ce controlleur affiche les cours qui apartien a un user
     *
     * @param CreneauRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/creneau', name: 'app_creneau', methods: ['GET'])]
    public function index(CreneauRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $creneaux = $paginator->paginate(
            $repository->findBy(['appartient_cours' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('creneau/index.html.twig', [
            'controller_name' => 'CreneauController',
            'creneaux' => $creneaux
        ]);
    }

    /**
     *
     * Ce cour nous permet d'ajouter un nouveaux creneau
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     *
     */

    #[Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")]
    #[Route('/creneau/nouveau', name: 'new_creneau', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();
        $creneau = new Creneau();
        $form = $this->createForm(CreneauType::class, $creneau, [
            'user' => $user,
        ]);

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

    /**
     *
     * Ce controlleur permet de modifer un creneau
     *
     * @param Creneau $creneau
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */

    #[IsGranted('ROLE_USER')]
    #[Route('/creneau/edition/{id}', name: 'edit_creneau', methods: ['GET', 'POST'])]
    public function edit(Creneau $creneau, EntityManagerInterface $manager, Request $request): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(CreneauType::class, $creneau, [
            'user' => $user,
        ]);
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

    /**
     *
     * ce controlleur permet de supprimer un creneau
     *
     * @param EntityManagerInterface $manager
     * @param Creneau $creneau
     * @return Response
     *
     */

    #[Route('/creneau/suppression/{id}', name: 'delete_creneau', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $manager, Creneau $creneau): Response
    {

        if (!$creneau) {
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
