<?php

declare(strict_types=1);

namespace App\Tests\Functional\Manager;

use App\Entity\Hotel;
use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class ManagerRoomTest extends WebTestCase
{
    public function testManagerCreateRoom(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_manager_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'julie@liz.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_manager_homePage');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $managerRepository = $entityManager->getRepository(Manager::class);
        $manager = $managerRepository->findOneByEmail('julie@liz.com');
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        /** @var Hotel $hotel */
        $hotel = $hotelRepository->findOneByManager($manager);
        $crawler = $client->request(Request::METHOD_GET, $router->generate('manager_room_create', [
            'idHotel' => $hotel->getId()
        ]));
        self::assertRouteSame('manager_room_create');
        $form = $crawler->filter('form[name=room]')->form([
            'room[name]' => 'A good suite in paris visual',
            'room[description]' => 'lorem',
            'room[price]' => 100,
            'room[mainPicture]' => 'ipsum',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_manager_homePage');
    }

    public function testManagerCreateRoomWithNoHotelExist(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_manager_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'julie@liz.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('security_manager_homePage');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('manager_room_create', [
            'idHotel' => 99999
        ]));
        $client->followRedirect();
        self::assertRouteSame('security_manager_homePage');
    }
}