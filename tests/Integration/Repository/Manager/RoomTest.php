<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository\Manager;

use App\Entity\Hotel;
use App\Entity\Manager;
use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RoomTest extends WebTestCase
{
    public function testRepositoryReturnManagerByFindOneByEmail(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $managerRepository = $entityManager->getRepository(Manager::class);
        /** @var Manager $manager */
        $manager = $managerRepository->findOneByEmail('julie@liz.com');

        $hotelRepository = $entityManager->getRepository(Hotel::class);
        $hotel = $hotelRepository->findOneByManager($manager);

        $roomRepository = $entityManager->getRepository(Room::class);
        $room = $roomRepository->findOneByHotel($hotel);

        $this->assertSame($room->getName(), 'Best Room');
        $this->assertSame($room->getDescription(), 'description room');
        $this->assertSame($room->getPrice(), 1000);
        $this->assertSame($room->getHotel(), $hotel);
    }
}
