<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Creneau;
use App\Entity\Eleve;
use App\Entity\Presence;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct(){
        $this->faker= Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $users = [];
        $cours=[];
        $creneau=[];
        $eleves=[];
        for ($i=1; $i<15; $i++)
        {
            $user = new Users();
            $user->setNom($this->faker->name())
                ->setPrenom($this->faker->firstName())
                ->setSexe($this->faker->randomElement(['homme', 'femme','binaire']))
                ->setEmail($this->faker->email())
                ->setTelephone($this->faker->phoneNumber())
                ->setEmploi($this->faker->randomElement(['FORMATEUR', 'SECRETAIRE','MANAGER']))
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
            $users[] = $user;
            $manager->persist($user);
        }

        for ($i=1; $i<15; $i++)
        {
            $cour= new Cours();
            $cour->setLibeleeCour($this->faker->randomElement(['CSS', 'JAVA','Boostrap','PHP','JS','Python','Framworks','C++','Algo','Math','Anglais','Histoire Techno']))
                ->setUsersCours($users[mt_rand(0,count($users)-1)])
                ->setDateDebut($this->faker->dateTime());

            $cours [] = $cour;
            $manager->persist($cour);


            for ($j=1 ; $j<5; $j++)
            {
                $creneau = new Creneau();
                $creneau->setHeureFin($this->faker->dateTime())
                    ->setHeureDebut($this->faker->dateTime())
                    ->setAppartientCours($cours [mt_rand(0,count($cours)-1)])
                    ->setLibelleJour($this->faker->dayOfWeek)
                    ->setNumeroSemaine($this->faker->numberBetween(1,52));

                $date = $cour->getDateDebut();
                $cour->setDateFin($date->modify('+' . (($i + 12) - $i) . 'months'))
                    ->addCreneauCour($creneau);
                $manager->persist($creneau);


                $eleve = new Eleve();

                $eleve->setNom($this->faker->firstName($gender = 'male'|'female'))
                    ->setPrenom($this->faker->lastName())
                    ->setEmail($this->faker->email())
                    ->setSexe($this->faker->randomElement(['homme', 'femme','binaire']))
                    ->setTelephone($this->faker->phoneNumber())
                    ->setNiveauEtude($this->faker->randomElement(['CAP', 'BAC','BAC+2']))
                    ->addCour($cour);
                $manager->persist($eleve);

                $presence = new Presence();

                $presence->setDatePresence($this->faker->dateTime())
                    ->setPresent($this->faker->boolean(65))
                    ->setDescription($this->faker->randomElement(['RAS','justifier','non justifier','malade','occasion Familiale']))
                    ->setPresenceCours($cour)
                    ->setPresenceEleve($eleve);
                $manager->persist($presence);
            }


        }

        $manager->flush();
    }
}
