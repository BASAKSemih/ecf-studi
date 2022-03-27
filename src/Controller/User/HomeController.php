<?php

declare(strict_types=1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/espace-utilisateur/', name: 'user_homePage')]
    public function home(): Response
    {
        return $this->render('user/home.html.twig');
    }
}
