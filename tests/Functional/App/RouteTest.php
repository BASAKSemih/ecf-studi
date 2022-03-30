<?php

declare(strict_types=1);

namespace App\Tests\Functional\App;

use App\Entity\Hotel;
use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class RouteTest extends WebTestCase
{
    public function testShowHomePage(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('homePage'));
        self::assertRouteSame('homePage');
    }

    public function testShowHotelById(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        $hotel = $hotelRepository->findOneById(1);
        $crawler = $client->request(Request::METHOD_GET, $router->generate('user_show_hotel', [
            'idHotel' => $hotel->getId()
        ]));
        self::assertRouteSame('user_show_hotel');
    }

    public function testShowHotelWithNotExist(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('user_show_hotel', [
            'idHotel' => 99999
        ]));
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

}
