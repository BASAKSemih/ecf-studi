<?php

namespace App\Tests\Integration\Repository\Manager;

use App\Entity\Hotel;
use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ManagerTest extends WebTestCase
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

        $this->assertSame($hotel->getName(), 'Paris Hotel');
        $this->assertSame($hotel->getDescription(), 'The best Paris hotel');
        $this->assertSame($hotel->getCity(), 'Paris');
        $this->assertSame($hotel->getAddress(), 'Paris address');
    }
}
