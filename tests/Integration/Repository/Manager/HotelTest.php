<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository\Manager;

use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HotelTest extends WebTestCase
{
    public function testRepositoryReturnHotelByFindOneByManger(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $managerRepository = $entityManager->getRepository(Manager::class);
        /** @var Manager $manager */
        $manager = $managerRepository->findOneByEmail('solene@liz.com');

        $this->assertSame($manager->getFirstName(), 'Liz');
        $this->assertSame($manager->getLastName(), 'Solene');
        $this->assertSame($manager->getEmail(), 'solene@liz.com');
    }
}