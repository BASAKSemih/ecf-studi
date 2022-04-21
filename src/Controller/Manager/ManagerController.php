<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use App\Entity\Hotel;
use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'security_manager_')]
final class ManagerController extends AbstractController
{
    #[Route('/espace-manager/', name: 'homePage')]
    public function homePage(): Response
    {
        /** @var Manager $manager */
        $manager = $this->getUser();
        /** @var Hotel $hotel */
        $hotel = $manager->getHotel();
        $rooms = $hotel->getRooms();

        return $this->render('manager/home/index.html.twig', [
            'hotel' => $hotel,
            'rooms' => $rooms,
        ]);
    }
}
