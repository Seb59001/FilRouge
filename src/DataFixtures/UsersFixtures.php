<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

for ($i = 1; $i <= 10; $i++) {
    $user = new Users();
    $user->setemail("Adressemail" . $i . "@KJST.fr");
    $user->setPassword("MDP" . $i);
    $user->setNom("Luffy" . $i);
    $user->setPrenom("Pirate" . $i);
    $user->setSexe('Femme');
    $user->setTelephone('0606060606');
    $user->setEmploi('Professeur');
    $user->setRoles(['ROLE_USER']);


    $manager->persist($user);
}
        $manager->flush();
    }
}
