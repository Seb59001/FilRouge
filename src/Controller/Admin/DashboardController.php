<?php

namespace App\Controller\Admin;

use App\Entity\Cours;
use App\Entity\Creneau;
use App\Entity\Eleve;
use App\Entity\Presence;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return  $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CLASSROOM - ADMIN');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', Users::class);
        yield MenuItem::linkToCrud('Cours', 'fa-solid fa-book', Cours::class);
        yield MenuItem::linkToCrud('Eleves', 'fa-solid fa-graduation-cap', Eleve::class);
        yield MenuItem::linkToCrud('Creneaux', 'fa-solid fa-calendar-days', Creneau::class);
        yield MenuItem::linkToCrud('Présences', 'fa-solid fa-list-check', Presence::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
