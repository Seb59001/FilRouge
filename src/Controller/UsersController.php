<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    #[Route('/users', name: 'app_users', methods:['GET'])]
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

    #[Route('/users/new', 'user.new', methods: ['GET', 'POST'])]
    public function new (): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);



        return $this->render('users/new.html.twig', [
           'form' => $form->createView()
        ]);
    }


}