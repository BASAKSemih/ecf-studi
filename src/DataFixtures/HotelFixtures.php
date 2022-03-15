<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\Manager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class HotelFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $objectManager): void
    {
        $manager = new Manager();
        $manager
            ->setFirstName('Julie')
            ->setLastName('Laura')
            ->setEmail('julie@liz.com')
            ->setPassword($this->userPasswordHasher->hashPassword($manager, 'password'));
        $objectManager->persist($manager);
        $objectManager->flush();

        $hotel = new Hotel();
        $hotel
            ->setManager($manager)
            ->setCity('Paris')
            ->setAddress('Paris address')
            ->setName('Paris Hotel')
            ->setDescription('The best Paris hotel');

        $objectManager->persist($hotel);
        $objectManager->flush();
    }
}
