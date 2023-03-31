<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 11; $i++) {
            $user = new User();
            $user->setAdressMail("Adressemail".$i."@KJST.fr");
            $user->setPassword("MDP".$i);
            $user->setNom("Luffy".$i);
            $user->setPrenom("Pirate".$i);
            $user->setSexe('Femme');
            $user->setTelephone('0606060606');
            $user->setEmploi('Professeur');
            $user->setRole('ROLE_USER');
            



            $manager->persist($user);

        }
        $manager->flush();
    }
}
