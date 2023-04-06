<?php

namespace App\DataFixtures;


use App\Entity\Cours;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CourFixtures extends Fixture
{
    private $usersRepository;

    public function __construct(UsersRepository $userRepository)
    {
        $this->usersRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i < 10; $i++) {

            $cour = new Cours();
            $cour->setLibeleeCour("Cour n° " . $i);
            $cour->setDateDebut(new \DateTimeImmutable());
            $date = $cour->getDateDebut();
            $cour->setDateFin($date->modify('+' . (($i + 12) - $i) . 'months'));



            $user = new Users();
            $user->setemail("Adressemails" . $i . "@KJST.fr");
            $user->setPassword("MDP" . $i);
            $user->setNom("Luffy" . $i);
            $user->setPrenom("Pirate" . $i);
            $user->setSexe('Femme');
            $user->setTelephone('0606060606');
            $user->setEmploi('Professeur');
            $user->setRoles(['ROLE_USER']);

            $cour->setUsersCours($user);
            $manager->persist($user);

            $manager->persist($cour);

        }
        $manager->flush();

    }




}