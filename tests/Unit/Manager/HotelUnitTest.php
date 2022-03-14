<?php

declare(strict_types=1);

namespace App\Tests\Unit\Manager;

use App\Entity\Hotel;
use App\Entity\Manager;
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

        $hotel = new Hotel();
        $hotel
            ->setName('Hotel Name')
            ->setAddress('Hotel address')
            ->setCity('Hotel city')
            ->setCreatedAt($dateTime)
            ->setManager($manager)
            ->setDescription('Hotel descr');

        $this->assertSame($hotel->getName(), 'Hotel Name');
        $this->assertSame($hotel->getAddress(), 'Hotel address');
        $this->assertSame($hotel->getCity(), 'Hotel city');
        $this->assertSame($hotel->getManager(), $manager);
        $this->assertSame($hotel->getDescription(), 'Hotel descr');
        $this->assertSame($hotel->getCreatedAt(), $dateTime);
        $this->assertNull($hotel->getId());
    }
}
