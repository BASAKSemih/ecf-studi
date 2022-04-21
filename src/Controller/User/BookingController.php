<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\Booking;
use App\Entity\Hotel;
use App\Entity\Room;
use App\Entity\User;
use App\Form\BookingJSType;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\HotelRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BookingController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected HotelRepository $hotelRepository,
        protected RoomRepository $roomRepository,
        protected BookingRepository $bookingRepository
    ) {
    }

    #[Route('/espace-utilisateur/{idHotel}/{idRoom}/reserver-une-suite', name: 'user_booking')]
    public function createBooking(int $idHotel, int $idRoom, Request $request): Response
    {
        $hotel = $this->hotelRepository->findOneById($idHotel);
        /** @var Room $room */
        $room = $this->roomRepository->findOneById($idRoom);
        if (!$hotel) {
            $this->addFlash('warning', "Cette hotel n'existe pas");

            return $this->redirectToRoute('user_homePage');
        }
        /* @phpstan-ignore-next-line  */
        if (!$room) {
            $this->addFlash('warning', "Cette chambre n'existe pas");

            return $this->redirectToRoute('homePage');
        }
        /** @var User $user */
        $user = $this->getUser();
        if ($room->getHotel() !== $hotel) {
            $this->addFlash('warning', 'Erreur');

            return $this->redirectToRoute('user_homePage');
        }
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setHotel($hotel);
            $booking->setUser($user);
            $booking->setRoom($room);

            $checkAvailability = $this->bookingRepository->findAvailableRooms($booking->getCheckIn(), $booking->getCheckOut(), $idRoom);
            if ($checkAvailability) {
                $this->addFlash('warning', 'Cette chambre est déjà réserver a ses dates');

                return $this->render('user/booking/create.html.twig', [
                    'room' => $room,
                    'hotel' => $hotel,
                    'form' => $form->createView(),
                ]);
            }
            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Vous avez bien réserver');

            return $this->redirectToRoute('user_show_all_booking');
        }

        return $this->render('user/booking/create.html.twig', [
            'room' => $room,
            'hotel' => $hotel,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/espace-utilisateur/reserver-une-suites', name: 'user_booking_js')]
    public function createBookingDynamic(Request $request): Response
    {
        $user = $this->getUser();
        $booking = new Booking();
        $form = $this->createForm(BookingJSType::class, $booking)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Hotel $hotel */
            $hotel = $booking->getRoom()->getHotel();
            $booking->setUser($user);
            $booking->setHotel($hotel);
            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Vous avez bien réserver');

            return $this->redirectToRoute('user_show_all_booking');
        }

        return $this->render('home/booking.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/espace-utilisateur/mes-reservation', name: 'user_show_all_booking')]
    public function viewAllBooking(): Response
    {
        $user = $this->getUser();
        $bookings = $this->bookingRepository->findByUser($user);

        return $this->render('user/booking/showAll.html.twig', [
            'bookings' => $bookings,
        ]);
    }
}
