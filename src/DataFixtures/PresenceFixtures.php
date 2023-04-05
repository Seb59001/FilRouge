<?php

namespace App\DataFixtures;

use App\Entity\Eleve;
use App\Entity\Cours;
use App\Entity\Presence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PresenceFixtures extends Fixture
        {
            public function load(ObjectManager $manager)
            {

                for ($i=1; $i<20;$i++)
                {
                    $eleve1 = new Eleve();
                    $eleve1->setNom('Dupont');
                    $eleve1->setPrenom('Alice')
                        ->setTelephone('Telephone'. $i)
                        ->setSexe('Féminin')
                        ->setNiveauEtude('Debutant' .$i)
                        ->setEmail('Email' . $i);
                    $manager->persist($eleve1);

                    $eleve2 = new Eleve();
                    $eleve2->setNom('Martin');
                    $eleve2->setPrenom('Bob')
                    ->setTelephone('Telephone'. $i)
                    ->setSexe('Masculin')
                    ->setNiveauEtude('Debutant' .$i)
                    ->setEmail('Email' . $i);
                    $manager->persist($eleve2);

                    $cours1 = new Cours();
                    $cours1->setLibeleeCour("Cour n° " . $i);
                    $cours1->setDateDebut(new \DateTimeImmutable());
                    $date = $cours1->getDateDebut();
                    $cours1->setDateFin($date->modify('+' . (($i + 12) - $i) . 'months'));
                    $manager->persist($cours1);

                    $cours2 = new Cours();
                    $cours2->setLibeleeCour("Cour n° " . $i++);
                    $cours2->setDateDebut(new \DateTimeImmutable());
                    $date = $cours2->getDateDebut();
                    $cours2->setDateFin($date->modify('+' . (($i + 12) - $i) . 'months'));
                    $manager->persist($cours2);

                    $presence1 = new Presence();
                    $presence1->setPresenceEleve($eleve1);
                    $presence1->setPresenceCours($cours1);
                    $presence1->setDatePresence(new \DateTime('2023-03-31'));
                    $presence1->setPresent(true);
                    $presence1->setDescription('RAS');
                    $manager->persist($presence1);

                    $presence2 = new Presence();
                    $presence2->setPresenceEleve($eleve2);
                    $presence2->setPresenceCours($cours1);
                    $presence2->setDatePresence(new \DateTime('2023-03-31'));
                    $presence2->setPresent(false);
                    $presence2->setDescription('Malade');
                    $manager->persist($presence2);

                    $presence3 = new Presence();
                    $presence3->setPresenceEleve($eleve1);
                    $presence3->setPresenceCours($cours2);
                    $presence3->setDatePresence(new \DateTime('2023-03-31'));
                    $presence3->setPresent(false);
                    $presence3->setDescription('Absence non justifiée');
                    $manager->persist($presence3);

                }


                $manager->flush();
            }
        }
