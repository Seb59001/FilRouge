<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourFixtures extends Fixture
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager  $manager): void
    {

        // $product = new Product();
        // $manager->persist($product);

        for ($i = 1; $i < 10; $i++) {

            $cour = new Cours();
            $cour->setLibeleeCour("Cour n° " . $i);
            $cour->setDateDebut(new \DateTimeImmutable());
            $date = $cour->getDateDebut();
            $cour->setDateFin($date->modify('+' . (($i + 12) - $i) . 'months'));



            $user = new User();
            $user->setAdressMail("Adressemail".$i."@KJST.fr");
            $user->setPassword("MDP".$i);
            $user->setNom("Luffy".$i);
            $user->setPrenom("Pirate".$i);
            $user->setSexe('Femme');
            $user->setTelephone('0606060606');
            $user->setEmploi('Professeur');
            $user->setRole('ROLE_USER');

            $cour->setUserCours($user);
            $manager->persist($user);

            $manager->persist($cour);

        }
        $manager->flush();
    }
}
