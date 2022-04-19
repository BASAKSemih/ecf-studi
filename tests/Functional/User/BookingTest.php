<?php

namespace App\Tests\Functional\User;

use App\Entity\Hotel;
use App\Entity\Manager;
use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class BookingTest extends WebTestCase
{
    public function testUserBooking(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'mercedes@c63.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('user_homePage');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        /** @var Hotel $hotel */
        $hotel = $hotelRepository->findOneByName("Paris Hotel");

        $roomRepository = $entityManager->getRepository(Room::class);
        /** @var Room $room */
        $room = $roomRepository->findOneByName('Best Room');


        $crawler = $client->request(Request::METHOD_GET, $router->generate('user_booking', [
            'idHotel' => $hotel->getId(),
            'idRoom' => $room->getId()
        ]));
        $form = $crawler->filter('form[name=booking]')->form([
            'booking[checkIn][day]' => 10,
            'booking[checkIn][month]' => 10,
            'booking[checkIn][year]' => 2023,
            'booking[checkOut][day]' => 10,
            'booking[checkOut][month]' => 10,
            'booking[checkOut][year]' => 2025,

        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('user_show_all_booking');
    }

    public function testUserBookingWithNoHotel(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'mercedes@c63.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('user_homePage');

        $crawler = $client->request(Request::METHOD_GET, $router->generate('user_booking', [
            'idHotel' => 13131313131,
            'idRoom' => 13131313131313
        ]));
        $client->followRedirect();
        self::assertRouteSame('user_homePage');
    }

    public function testUserBookingWithNoRoom(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'mercedes@c63.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('user_homePage');


        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        /** @var Hotel $hotel */
        $hotel = $hotelRepository->findOneByName("Paris Hotel");

        $crawler = $client->request(Request::METHOD_GET, $router->generate('user_booking', [
            'idHotel' => $hotel->getId(),
            'idRoom' => 22713
        ]));

    }

    public function testUserBookingWithRoomNotToHotel(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'mercedes@c63.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('user_homePage');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        /** @var Hotel $hotel */
        $hotel = $hotelRepository->findOneByName("Paris Hotel");

        $roomRepository = $entityManager->getRepository(Room::class);
        /** @var Room $room */
        $room = $roomRepository->findOneByName('Best Room in testtt');


        $crawler = $client->request(Request::METHOD_GET, $router->generate('user_booking', [
            'idHotel' => $hotel->getId(),
            'idRoom' => $room->getId()
        ]));

        $client->followRedirect();
        self::assertRouteSame('user_homePage');
    }

    public function testUserBookingARoomAlreadyBooked(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'david@c63.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('user_homePage');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        /** @var Hotel $hotel */
        $hotel = $hotelRepository->findOneByName("Paris Hotel");

        $roomRepository = $entityManager->getRepository(Room::class);
        /** @var Room $room */
        $room = $roomRepository->findOneByName('Best Room');


        $crawler = $client->request(Request::METHOD_GET, $router->generate('user_booking', [
            'idHotel' => $hotel->getId(),
            'idRoom' => $room->getId()
        ]));
        $form = $crawler->filter('form[name=booking]')->form([
            'booking[checkIn][day]' => 10,
            'booking[checkIn][month]' => 10,
            'booking[checkIn][year]' => 2023,
            'booking[checkOut][day]' => 10,
            'booking[checkOut][month]' => 10,
            'booking[checkOut][year]' => 2025,

        ]);
        $client->submit($form);
        self::assertRouteSame('user_booking');
    }
}
