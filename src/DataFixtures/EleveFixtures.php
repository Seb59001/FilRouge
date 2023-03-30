<?php

namespace App\DataFixtures;

use App\Entity\Eleve;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EleveFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 60; $i++) {

        $eleve = new Eleve();
        $eleve->setNom('Nom' . $i)
            ->setPrenom('Prenom' . $i)
            ->setTelephone('Telephone'. $i)
            ->setSexe('Masculin')
            ->setNiveauEtude('Debutant' .$i)
            ->setEmail('Email' . $i);


        $manager->persist($eleve);
        }

        

        $manager->flush();
    }
}
