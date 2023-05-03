<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Creneau;
use App\Form\CreneauType;
use App\Repository\CoursRepository;
use App\Repository\CreneauRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class CreneauController extends AbstractController
{
    /**
     *
     * ce controlleur affiche les cours qui apartien a un user
     *
     * @param CreneauRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Security("is_granted('ROLE_USER')")]
    #[Route('/creneau_user', name: 'app_creneau_user', methods: ['GET'])]
    public function index(CreneauRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $creneaux = $paginator->paginate(
            $repository->getCreneauxByUser($this->getUser()),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('creneau/index.html.twig', [
            'controller_name' => 'CreneauController',
            'creneaux' => $creneaux
        ]);
    }

    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/creneau', name: 'app_creneau', methods: ['GET'])]
    public function indexAdmin(CreneauRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $creneaux = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('creneau/index.html.twig', [
            'controller_name' => 'CreneauController',
            'creneaux' => $creneaux
        ]);
    }

    /**
     *
     * Ce cour nous permet d'ajouter un nouveaux creneau
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     *
     */

    #[Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")]
    #[Route('/creneau/nouveau', name: 'new_creneau', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();
        $creneau = new Creneau();
        $form = $this->createForm(CreneauType::class, $creneau, [
            'user' => $user,
        ]);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $creneau = $form->getData();
            // $debutPeriode = $creneau->getAppartientCours()->getDateDebut()->format('Y-m-d H:i:s');
            $debut = $creneau->getDateDebutCours()->format('Y-m-d H:i:s');  
            $fin = $creneau->getDateFinCours()->format('Y-m-d H:i:s');
            $debutPeriode = $creneau->getAppartientCours()->getDateDebut();
            $debutPeriode->setTime((int) $debut[11] . $debut[12], (int) $debut[14] . $debut[15], (int) $debut[17] . $debut[18]);
            $debutPeriode = $debutPeriode->format('Y-m-d H:i:s');
            $finPeriode = $creneau->getAppartientCours()->getDateFin();
            $finPeriode->setTime((int) $fin[11] . $fin[12], (int) $fin[14] . $fin[15], (int) $fin[17] . $fin[18]);
            $finPeriode = $finPeriode->format('Y-m-d H:i:s');


            $finPeriode = $creneau->getAppartientCours()->getDateFin()->format('Y-m-d H:i:s');
            // Vérifier si la date de début du créneau est antérieure à la date de début du cours
            $debut = $creneau->getDateDebutCours()->format('Y-m-d H:i:s');
            if ($debut < $debutPeriode) {
                // Ajouter un message d'erreur à la session flash
                $dateDebut = DateTime::createFromFormat('Y-m-d H:i:s', $debutPeriode);
                $this->addFlash(
                    'error',
                    "La date du créneau de cours ne peut pas être antérieure à la date de début du cours. Le cours commence le {$debutPeriode}"
                );


                // Rediriger l'utilisateur vers la page du formulaire
                return $this->redirectToRoute('new_creneau');
            }
            $fin = $creneau->getDateFinCours()->format('Y-m-d H:i:s');
            if ($fin > $finPeriode) {
                DateTime::createFromFormat('Y-m-d H:i:s', $finPeriode);
                // Ajouter un message d'erreur à la session flash
                $this->addFlash(
                    'error',
                    "La date du créneau de cours ne peut pas être ultérieure à la date de fin du cours. Le cours se termine le {$finPeriode}"
                );


                // Rediriger l'utilisateur vers la page du formulaire
                return $this->redirectToRoute('new_creneau');
            }

            $manager->persist($creneau);
            $manager->flush();

            // Calculer le nombre de semaines entre la date de début et la date de fin
            $dateDebut = DateTime::createFromFormat('Y-m-d H:i:s', $debutPeriode);
            $dateFin = DateTime::createFromFormat('Y-m-d H:i:s', $finPeriode);
            $diff = $dateDebut->diff($dateFin);



            $nbSemaines = intval($diff->format('%a') / 7);
            for ($i = 0; $i < $nbSemaines; $i++) {
                // Obtenir les données du formulaire
                $creneau = $form->getData();
                $idCours = $creneau->getAppartientCours();
                $debut = $creneau->getDateDebutCours();
                $fin = $creneau->getDateFinCours();




                // Créer un nouveau Creneau avec les dates modifiées
                $user = $this->getUser();
                $newCreneau = new Creneau();
                $newCreneau->setAllDay(false);
                $newCreneau->setAppartientCours($idCours);
                $newCreneau->setDateDebutCours($debut);
                $newCreneau->setDateFinCours($fin);



                // Ajouter une semaine à la date de début et fin
                $debut = $debut->modify("+7 day");
                $fin = $fin->modify("+7 day");


                $newData = [
                    'date_debut_cours' => $debut,
                    'date_fin_cours' => $fin,
                    'all_day' => false,
                    'appartientcours' => $idCours,
                ];


                $newForm = $this->createForm(CreneauType::class, $newCreneau, [
                    'user' => $user,
                ]);



                $newRequest = Request::create('', 'POST', [
                    'creneau' => $newData,
                ]);

                // Traite le nouveau formulaire avec la nouvelle instance de Request
                $newForm->handleRequest($newRequest);



                // Si le formulaire est soumis et valide, persiste le nouveau créneau
                if ($newForm->isSubmitted()) {
                    $newCreneau = $newForm->getData();
                    $manager->persist($newCreneau);
                    $manager->flush();
                }
            }


            // Ajouter un message de succès à la session flash
            $this->addFlash(
                'success',
                "Les " . ($nbSemaines + 1) . " créneaux ont été insérés avec succès !"
            );

            // Rediriger l'utilisateur vers la page des créneaux
            return $this->redirectToRoute('app_creneau');
        }


        return $this->render('creneau/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     *
     * Ce controlleur permet de modifer un creneau
     *
     * @param Creneau $creneau
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */

    #[Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")]
    #[Route('/creneau/edition/{id}', name: 'edit_creneau', methods: ['GET', 'POST'])]
    public function edit(Creneau $creneau, EntityManagerInterface $manager, Request $request): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(CreneauType::class, $creneau, [
            'user' => $user,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $creneau = $form->getData();

            $manager->persist($creneau);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le créneau a été modifié avec succès ! '
            );

            return $this->redirectToroute('app_creneau');
        }

        return $this->render('creneau/edit.html.twig', [
            'form' => $form
        ]);
    }

    /**
     *
     * ce controlleur permet de supprimer un creneau
     *
     * @param EntityManagerInterface $manager
     * @param Creneau $creneau
     * @return Response
     *
     */

    #[IsGranted('ROLE_USER')]
    #[Route('/creneau/suppression/{id}', name: 'delete_creneau', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $manager, Creneau $creneau): Response
    {

        if (!$creneau) {
            $this->addFlash(
                'success',
                "Le créneau en question n'a pas été trouvé"
            );

            return $this->redirectToroute('app_creneau');
        }
        $manager->remove($creneau);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le créneau a été supprimé avec succès !"
        );

        return $this->redirectToroute('app_creneau');
    }
}
