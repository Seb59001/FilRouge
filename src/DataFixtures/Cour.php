<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Cour extends Fixture
{
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


            $manager->persist($cour);

            $manager->flush();

        }
    }
}
