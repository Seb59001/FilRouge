<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UpdatePasswordType;
use App\Form\UsersType;
use App\Repository\UsersRepository;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


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

    #[IsGranted('ROLE_ADMIN')]
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
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/users/new', 'user.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher,  GoogleAuthenticatorInterface $authenticator): Response
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

            $secret =$authenticator->generateSecret();

            $user->setGoogleAuthenticatorSecret($secret);

            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre inscription est validée'
            );
            return $this->redirectToRoute('home');
        }
        return $this->render('users/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[IsGranted('IS_AUTHENTICATED')]
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
    #[IsGranted('ROLE_ADMIN')]

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

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/profil/modificationMdp', 'user.edit.password', methods: ['GET', 'POST'])]
    public function editPassword(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {

        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordType::class, $user);

        $form->handleRequest($request);
 
        $user = $form->getData();

        if($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();
            if($hasher->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_pwd);

                $user->setPassword($password);

                                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié.'
                );
                $manager->persist($user);
                $manager->flush();

            } else {
                            $this->addFlash(
                                'warning',
                                'Le mot de passe renseigné est incorrect.'
                            );
                        }
                    

           }
       return $this->render('profil/UpdatePassword.html.twig', ['form' => $form->createView()]);
   }

    // #[Security("is_granted('ROLE_USER') and user === choosenUser")]
    // #[Route('/profil/modificationMdp/{id}', 'user.edit.password', methods: ['GET', 'POST'])]
    // public function editPassword(
    //     Users $choosenUser,
    //     Request $request,
    //     EntityManagerInterface $manager,
    //     UserPasswordHasherInterface $hasher
    // ): Response {
    //     $form = $this->createForm(UpdatePasswordType::class);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if ($hasher->isPasswordValid($choosenUser, $form->getData()['plainPassword'])) {
    //             $choosenUser->setPlainPassword(
    //                 $form->getData()['newPassword']
    //             );


    //             $this->addFlash(
    //                 'success',
    //                 'Le mot de passe a été modifié.'
    //             );


    //             $manager->persist($choosenUser);
    //             $manager->flush();

    //             return $this->redirectToRoute('app_users');

    //         } else {
    //             $this->addFlash(
    //                 'warning',
    //                 'Le mot de passe renseigné est incorrect.'
    //             );
    //         }
    //     }


    //     return $this->render('profil/UpdatePassword.html.twig', [
    //         'form' => $form->createView(),
    //         'notification' => $notification
    //     ]);
            


    //     }


    //     return $this->render('profil/UpdatePassword.html.twig', [
    //         'form' => $form->createView()
    //     ]);

    }

