<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Creneau;
use App\Entity\Eleve;
use App\Entity\Presence;
use App\Entity\User;
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

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $cours = [];
        $creneaux = [];
        $eleves = [];

        for ($i = 1; $i < 20; $i++) {
            $user = new User();
            $user->setNom($this->faker->name())
                ->setPrenom($this->faker->firstName())
                ->setSexe($this->faker->randomElement(['homme', 'femme', 'binaire']))
                ->setEmail($this->faker->email())
                ->setTelephone($this->faker->phoneNumber())
                ->setEmploi($this->faker->randomElement(['FORMATEUR', 'SECRETAIRE']))
                ->setRoles($this->faker->randomElement([['ROLE_USER'], ['ROLE_ADMIN']]))
                ->setPlainPassword('password');

            if ($user->getEmploi() == 'FORMATEUR') {
                for ($j = 0; $j < 4; $j++) {
                    $cour = new Cours();
                    $cour->setLibelleCour($this->faker->randomElement(['CSS', 'JAVA', 'Boostrap', 'PHP', 'JS', 'Python', 'Frameworks', 'C++', 'Algo', 'Math', 'Anglais', 'Histoire Techno']));

                    $cour->setUser($user)
                        ->setDateDebut($this->faker->dateTimeThisYear())
                        ->setDateFin($this->faker->dateTimeThisYear('+6 months'));
                    $cours[] = $cour;
                    $manager->persist($cour);

                    for ($k = 0; $k < 4; $k++) {
                        $creneau = new Creneau();
                        $creneau->setDateDebut($this->faker->dateTime())
                            ->setDateFin($this->faker->dateTime())
                            ->setCours($cour)
                            ->setAllDay(false);
                        $creneaux[] = $creneau;
                        $manager->persist($creneau);
                    }
                }
            }
            $manager->persist($user);
        }

        foreach ($cours as $cour) {
            for ($i = 0; $i < 16; $i++) {
                $eleve = new Eleve();

                $eleve->setNom($this->faker->firstName($gender = 'male' | 'female'))
                    ->setPrenom($this->faker->lastName())
                    ->setEmail($this->faker->email())
                    ->setSexe($this->faker->randomElement(['homme', 'femme', 'binaire']))
                    ->setTelephone($this->faker->phoneNumber())
                    ->setNiveauEtude($this->faker->randomElement(['CAP', 'BAC', 'BAC+2']))
                    ->addCours($cour);
                $eleves[] = $eleve;
                $manager->persist($eleve);

                $presence = new Presence();

                $presence->setDatePresence($this->faker
