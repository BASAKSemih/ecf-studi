<?php

declare(strict_types=1);

namespace App\Tests\Unit\Manager;

use App\Entity\Hotel;
use App\Entity\Manager;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class ManagerUnitTest extends TestCase
{
    public function testManagerAssertSame(): void
    {
        $manager = new Manager();
        $dateTime = new DateTimeImmutable();
        $manager
            ->setFirstName('User')
            ->setLastName('User')
            ->setEmail('user@email.com')
            ->setPassword('password')
            ->setRoles(['MANAGER'])
            ->setCreatedAt($dateTime);

        $hotel = new Hotel();
        $hotel
            ->setName('Hotel Name')
            ->setAddress('Hotel address')
            ->setCity('Hotel city')
            ->setCreatedAt($dateTime)
            ->setManager(new Manager())
            ->setDescription('Hotel descr');

        $manager->setHotel($hotel);

        $this->assertSame($manager->getFirstName(), 'User');
        $this->assertSame($manager->getLastName(), 'User');
        $this->assertSame($manager->getEmail(), 'user@email.com');
        $this->assertSame($manager->getPassword(), 'password');
        $this->assertSame($manager->getCreatedAt(), $dateTime);
        $this->assertSame($manager->getUsername(), 'user@email.com');
        $this->assertSame($manager->getUserIdentifier(), 'user@email.com');
        $this->assertSame($manager->getRoles(), ['MANAGER']);
        $this->assertSame($manager->getHotel(), $hotel);
        $this->assertNull($manager->getSalt());
        $this->assertNull($manager->getId());
    }
}
