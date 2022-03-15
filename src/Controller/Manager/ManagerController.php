<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'security_manager_')]
final class ManagerController extends AbstractController
{
    #[Route('/espace-manager/', name: 'homePage')]
    public function homePage(): Response
    {
        return $this->render('manager/home/index.html.twig');
    }
}
