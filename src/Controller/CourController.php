<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Presence;
use App\Form\CourType;
use App\Repository\CoursRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class CourController extends AbstractController
{
    /**
     *
     * ce controlleur ne permet de voir tout les cours
     *
     * @param CoursRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/cour_user', name: 'app_cour_user', methods: ['GET', 'POST'])]
    public function index(CoursRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $listeCour=$paginator->paginate(
            $repository->findBy(['user_cours'=>$this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('cour/cour.html.twig', [
            'controller_name' => 'Cours',
            'courListe'=>$listeCour
        ]);
    }

    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/cour', name: 'app_cour', methods: ['GET', 'POST'])]
    public function Admin(CoursRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $listeCour=$paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('cour/cour.html.twig', [
            'controller_name' => 'Cours',
            'courListe'=>$listeCour
        ]);
    }

    /**
     *
     * Ce controlleur nous permet de crees des cours
     * ROLE_ADMIN
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/cour/new', name: 'app_cour_new', methods: ['GET', 'POST'])]
    public function new (Request $request, EntityManagerInterface $manager):Response
    {
        $cour= new Cours();
        $form= $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $cour= $form->getData();
            $manager->persist($cour);
            $manager->flush();
            $this->addFlash(
                'success',
                'Cour Ajouter avec succés!'
            );

            return $this->redirectToRoute('app_cour');
        }

        return  $this->render('cour/add.html.twig',[
            'form'=> $form->createView()
        ]);

    }


    /**
     *
     * Ce controlleur nous permet de crees des cours
     * ROLE_USER
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/cour/add', name: 'app_cour_add', methods: ['GET', 'POST'])]
    public function add (Request $request, EntityManagerInterface $manager):Response
    {
        $cour= new Cours();
        $form= $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $cour= $form->getData();
            $cour->setUsersCours($this->getUser());
            $manager->persist($cour);
            $manager->flush();
            $this->addFlash(
                'success',
                'Cour Ajouter avec succés!'
            );
            return $this->redirectToRoute('app_cour');
        }
        return  $this->render('cour/add.html.twig',[
            'form'=> $form->createView()
        ]);

    }

    /**
     *
     * Ce Controller permet de modifier un cour
     *
     * @param Cours $cour
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     *
     */
    #[Security("is_granted('ROLE_USER') and user === cour.getUsersCours()")]
    #[Route('/cour/edit/{id}', name: 'app_cour_edit', methods: ['POST', 'GET'])]
    public function edit(Cours $cour,Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cour = $form->getData();
            $manager->persist($cour);
            $manager->flush();
            $this->addFlash(
                'success',
                'Cour modifier avec succés!'
            );
            return $this->redirectToRoute('app_cour');
        }

        return $this->render('cour/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     *
     * ce controler permet de supprimer un cour
     *
     * @param EntityManagerInterface $manager
     * @param Cours $cour
     * @return Response
     */

    #[Security("is_granted('ROLE_USER') and user === cour.getUsersCours()")]
    #[Route('cour/delete/{id}', name: 'app_cour_delete', methods: ['POST', 'GET'])]
    public function delete (EntityManagerInterface $manager, Cours $cour):Response
    {
        if (!$cour) {
            $this->addFlash(
                'danger',
                'Le cour n\'existe pas !'
            );

            return $this->redirectToRoute('app_cour');
        }
        $courPresence= $cour->getPresenceCours();
        if($courPresence){
            $this->addFlash(
                'danger',
                'Le cour contien des présences !'
            );

            return $this->redirectToRoute('app_cour');
        }

        $manager->remove($cour);

        $manager->flush();

        $this->addFlash(
            'success',
            'Le Cours a été supprimé avec succés!'
        );

        return $this->redirectToRoute('app_cour');
    }


}
