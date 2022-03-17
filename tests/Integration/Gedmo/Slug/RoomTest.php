<?php

declare(strict_types=1);

namespace App\Tests\Integration\Gedmo\Slug;

use App\Entity\Hotel;
use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RoomTest extends WebTestCase
{
    public function testIfGedmoSlugRoom(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        $hotel = $hotelRepository->findOneById(1);
        $room = new Room();
        $room
            ->setHotel($hotel)
            ->setName('Test If Slug Work')
            ->setDescription('description room')
            ->setPrice(1000)
            ->setMainPicture('path picture');
        $entityManager->persist($room);
        $entityManager->flush();
        $this->assertSame($room->getSlug(), 'test-if-slug-work');
    }
}
