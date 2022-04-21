<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Contact;
use App\Form\BookingJSType;
use App\Form\ContactType;
use App\Repository\BookingRepository;
use App\Repository\HotelRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'homePage')]
    public function home(HotelRepository $hotelRepository): Response
    {
        $hotels = $hotelRepository->findAll();

        return $this->render('home/home.html.twig', [
            'hotels' => $hotels,
        ]);
    }

    #[Route('/contacter-le-groupe-hotelier', name: 'visitor_contact')]
    public function createContact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Le message à bien été envoyer vous recevrez une réponse rapidement');

            return $this->redirectToRoute('homePage');
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    #[Route('/reserver-une-suites', name: 'visitor_booking')]
    public function createBookingDynamic(Request $request): Response
    {
        $user = $this->getUser();
        if ($user) {
            return $this->redirectToRoute('user_booking_js');
        }
        $booking = new Booking();
        $form = $this->createForm(BookingJSType::class, $booking)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Veuillez vous connecter pour procédér a la réservation');

            return $this->redirectToRoute('security_user_login');
        }

        return $this->render('home/booking.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    #[Route('/verifier-une-suites', name: 'visitor_booking_check', methods: ['GET'])]
    public function checkBookingAvailable(BookingRepository $bookingRepository, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $checkIn = new DateTime($request->query->get('checkIn'));
        $checkOut = new DateTime($request->query->get('checkOut'));
        $idRoom = $request->query->get('idRoom');

        $checkAvailability = $bookingRepository->findAvailableRooms($checkIn, $checkOut, $idRoom);
        if ($checkAvailability) {
            return new JsonResponse(400);
        }

        return new JsonResponse(200);
    }
}
