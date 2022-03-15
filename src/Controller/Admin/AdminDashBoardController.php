<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Hotel;
use App\Entity\Manager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'security_admin_')]
final class AdminDashBoardController extends AbstractDashboardController
{
    #[Route('/espace-administrateur', name: 'homePage')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ecf');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Crée un Admin', 'fas fa-list', Admin::class);
        yield MenuItem::linkToCrud('Crée un Manager', 'fas fa-list', Manager::class);
        yield MenuItem::linkToCrud('Crée un Hotel', 'fas fa-list', Hotel::class);
    }
}
