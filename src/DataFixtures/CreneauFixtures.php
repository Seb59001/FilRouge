<?php

namespace App\DataFixtures;

use App\Entity\Creneau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreneauFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {

         $creneau = new Creneau();
         $manager->persist($creneau);
         $creneau
         ->setHeureDebut(new \DateTime())
         ->setHeureFin(new \DateTime())
         ->setLibelleJour('jeudi')
         ->setNumeroSemaine($i);

        }

        $manager->flush();
    }
}
