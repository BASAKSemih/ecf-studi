<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use App\Entity\Hotel;
use App\Entity\Manager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'security_manager_')]
final class ManagerDashBoardController extends AbstractDashboardController
{
    #[Route('/espace-manager', name: 'homePage')]
    public function index(): Response
    {
        return $this->render('manager/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ecf');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    }
}
