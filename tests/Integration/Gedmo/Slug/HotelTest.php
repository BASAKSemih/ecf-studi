<?php

declare(strict_types=1);

namespace App\Tests\Integration\Gedmo\Slug;

use App\Entity\Hotel;
use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HotelTest extends WebTestCase
{
    public function testIfGedmoSlugHotel(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $managerRepository = $entityManager->getRepository(Manager::class);

        $manager = new Manager();
        $manager
            ->setFirstName('Testtt')
            ->setLastName('Testtt')
            ->setEmail('testtt@liz.com')
            ->setPassword('dontusethat');
        $entityManager->persist($manager);
        $entityManager->flush();
        $hotel = new Hotel();
        $hotel
            ->setName('Hotel Name Slug Test')
            ->setAddress('Hotel address')
            ->setCity('Hotel city')
            ->setManager($manager)
            ->setDescription('Hotel descr');
        $entityManager->persist($hotel);
        $entityManager->flush();
        $this->assertSame($hotel->getSlug(), 'hotel-name-slug-test');
    }
}
