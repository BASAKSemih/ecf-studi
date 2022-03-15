<?php

declare(strict_types=1);

namespace App\Tests\Unit\Manager;

use App\Entity\Hotel;
use App\Entity\Manager;
use App\Entity\Room;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class HotelUnitTest extends TestCase
{
    public function testHotelAssertSame(): void
    {
        $manager = new Manager();
        $dateTime = new DateTimeImmutable();
        $manager
            ->setFirstName('manager')
            ->setLastName('manager')
            ->setEmail('manager@email.com')
            ->setPassword('password')
            ->setRoles(['MANAGER']);

        $roomTwo = new Room();
        $roomTwo
            ->setName('Best roomTwo')
            ->setDescription('description roomTwo')
            ->setPrice(1000)
            ->setMainPicture('path picture');

        $this->assertSame($roomTwo->getName(), 'Best roomTwo');
        $this->assertSame($roomTwo->getDescription(), 'description roomTwo');
        $this->assertSame($roomTwo->getPrice(), 1000);
        $this->assertSame($roomTwo->getMainPicture(), 'path picture');
        $this->assertNull($roomTwo->getId());

        $hotel = new Hotel();
        $hotel
            ->setName('Hotel Name')
            ->setAddress('Hotel address')
            ->setCity('Hotel city')
            ->setCreatedAt($dateTime)
            ->addRoom($roomTwo)
            ->setManager($manager)
            ->setDescription('Hotel descr');

        $this->assertSame($hotel->getName(), 'Hotel Name');
        $this->assertSame($hotel->getAddress(), 'Hotel address');
        $this->assertSame($hotel->getCity(), 'Hotel city');
        $this->assertSame($hotel->getManager(), $manager);
        $this->assertSame($hotel->getDescription(), 'Hotel descr');
        $this->assertSame($hotel->getCreatedAt(), $dateTime);

        $this->assertArrayHasKey('0', ['0' => $roomTwo]);
        $this->assertNull($hotel->getId());

        $room = new Room();
        $room
            ->setHotel($hotel)
            ->setName('Best Room')
            ->setDescription('description room')
            ->setPrice(1000)
            ->setMainPicture('path picture');

        $this->assertSame($room->getName(), 'Best Room');
        $this->assertSame($room->getDescription(), 'description room');
        $this->assertSame($room->getPrice(), 1000);
        $this->assertSame($room->getMainPicture(), 'path picture');
        $this->assertSame($room->getHotel(), $hotel);
        $this->assertNull($room->getId());
    }
}
