<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HotelController extends AbstractController
{
    #[Route('/espace-utilisateur/hotel/{idHotel}', name: 'user_show_hotel')]
    public function home(int $idHotel, HotelRepository $hotelRepository): Response
    {
        $hotel = $hotelRepository->findOneById($idHotel);
        if (!$hotel) {
            $this->addFlash('warning', "Cette hotel n'existe pas");
            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/hotel/show.html.twig', [
            'hotel' => $hotel
        ]);
    }
}
