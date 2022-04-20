<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\Manager;
use App\Entity\Room;
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
            ->setPicture("55bc3acfee8fbd01ad61bf4050b350a2dd875c0f.jpg")
            ->setAddress('Paris address')
            ->setName('Paris Hotel')
            ->setDescription('The best Paris hotel');

        $objectManager->persist($hotel);
        $objectManager->flush();

        $room = new Room();
        $room
            ->setHotel($hotel)
            ->setName('Best Room')
            ->setDescription('description room')
            ->setPrice(1000)
            ->setMainPicture('qsdqsdqsd.jpeg');

        $objectManager->persist($room);
        $objectManager->flush();

        $manager2 = new Manager();
        $manager2
            ->setFirstName('Paul')
            ->setLastName('Bernard')
            ->setEmail('paul@bernard.com')
            ->setPassword($this->userPasswordHasher->hashPassword($manager2, 'password'));
        $objectManager->persist($manager2);
        $objectManager->flush();

        $hotel2 = new Hotel();
        $hotel2
            ->setManager($manager2)
            ->setCity('Marseille')
            ->setPicture("55bc3acfee8fbd01ad61bf4050b350a2dd875c0f.jpg")
            ->setAddress('Marseille address')
            ->setName('Marseille Hotel')
            ->setDescription('The best Paris hotel 222');

        $objectManager->persist($hotel2);
        $objectManager->flush();

        $room2 = new Room();
        $room2
            ->setHotel($hotel2)
            ->setName('Best Room in Mulhouse')
            ->setDescription('description room mulhouse 2')
            ->setPrice(1000)
            ->setMainPicture('qsdqsdqsd.jpeg');

        $objectManager->persist($room2);
        $objectManager->flush();

        $room2 = new Room();
        $room2
            ->setHotel($hotel2)
            ->setName('Best Room in testtt')
            ->setDescription('description room mulhouse 2')
            ->setPrice(1000)
            ->setMainPicture('qsdqsdqsd.jpeg');

        $objectManager->persist($room2);
        $objectManager->flush();

        for ($r = 0; $r < 5; ++$r) {
            $room = new Room();
            $room
                ->setHotel($hotel)
                ->setName('Best Room qdsqdqqd')
                ->setDescription('description room')
                ->setPrice(1000)
                ->setMainPicture('qsdqsdqsd.jpeg');
            $objectManager->persist($room);
        }
        $objectManager->flush();
    }
}
