<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UpdatePasswordType;
use App\Form\UsersType;
use App\Repository\UsersRepository;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UsersController extends AbstractController
{
    /**
     * La vue de tous les users
     *
     * @param UsersRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function index(UsersRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render(
            'users/users.html.twig',
            [
                'users' => $users,
            ]
        );
    }


    /**
     * Créer un nouvel utilisateur
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/users/new', 'user.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user->setPassword(
                $hasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );


            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre inscription est validée'
            );
            return $this->redirectToRoute('app_users');
        }
        return $this->render('users/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/users/edition/{id}', 'users.edit', methods: ['GET', 'POST'])]
    public function edit(Users $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UsersType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Les informations ont été mises à jour'
            );
            return $this->redirectToRoute('app_users');
        }

        return $this->render('users/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/users/suppression/{id}', 'users.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Users $user): Response
    {
        if (!$user) {
            $this->addFlash(
                'success',
                'L\'utilisateur ne fait pas parti de la liste'
            );
            return $this->redirectToRoute('app_users');
        }
        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            'L\'utilisateur a bien été supprimé de la liste'
        );
        return $this->redirectToRoute('app_users');
    }

    #[Route('/profil/modificationMdp/{id}', 'user.edit.password', methods: ['GET', 'POST'])]
    public function editPassword(Users $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UpdatePasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user->setPlainPassword(
                $form->getData()->getNewPassword()
                );

                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié.'
                );

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('user.edit.password');

            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            } 
        }
        return $this->render('profil/UpdatePassword.html.twig', ['form' => $form->createView()]);
    }

}