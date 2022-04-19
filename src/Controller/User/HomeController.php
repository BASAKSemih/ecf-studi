<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/espace-utilisateur/', name: 'user_homePage')]
    public function home(HotelRepository $hotelRepository): Response
    {
        $hotels = $hotelRepository->findAll();

        return $this->render('home/home.html.twig', [
            'hotels' => $hotels,
        ]);
    }
}
