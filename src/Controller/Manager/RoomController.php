<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\HotelRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route(name: 'manager_room_')]
final class RoomController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security $security,
        protected HotelRepository $hotelRepository,
        protected RoomRepository $roomRepository) {
    }

    #[Route('/espace-manager/ajouter-une-suite/{idHotel}', name: 'create')]
    public function createRoom(int $idHotel, Request $request): Response
    {
        $hotel = $this->hotelRepository->findOneById($idHotel);
        if (!$hotel) {
            $this->addFlash('warning', "L'Hote n'existe pas");

            return $this->redirectToRoute('security_manager_homePage');
        }
        $this->security->isGranted('IS_OWNER', $hotel);
        $this->denyAccessUnlessGranted('IS_OWNER', $hotel, "L'hotel ne vous appartient pas");
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $room->setHotel($hotel);
            $this->entityManager->persist($room);
            $this->entityManager->flush();
            $this->addFlash('success', 'La suite à bien été crée');

            return $this->redirectToRoute('security_manager_homePage'); // TODO redirect to room show page
        }

        return $this->render('manager/room/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/espace-manager/ajouter-une-suite/{idHotel}/{idRoom}', name: 'edit')]
    public function editRoom(int $idHotel, int $idRoom, Request $request): Response
    {
        $hotel = $this->hotelRepository->findOneById($idHotel);
        if (!$hotel) {
            $this->addFlash('warning', "L'Hote n'existe pas");

            return $this->redirectToRoute('security_manager_homePage');
        }
        $this->security->isGranted('IS_OWNER', $hotel);
        $this->denyAccessUnlessGranted('IS_OWNER', $hotel, "L'hotel ne vous appartient pas");
        $room = $this->roomRepository->findOneById($idRoom);
        if (!$room) {
            $this->addFlash('warning', "La chambre hotel n'existe pas");

            return $this->redirectToRoute('security_manager_homePage');
        }
        if ($room->getHotel() !== $hotel) {
            $this->addFlash('warning', "La chambre n'appartient pas a hotel que vous gèrer");

            return $this->redirectToRoute('security_manager_homePage');
        }
        $form = $this->createForm(RoomType::class, $room)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'La suite à bien été modifier');

            return $this->redirectToRoute('security_manager_homePage'); // TODO redirect to room show page
        }

        return $this->render('manager/room/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
