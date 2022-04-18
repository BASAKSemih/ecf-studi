<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method              findAll()                                                                     array<int, Booking>
 * @method              findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) array<array-key, Booking>
 *
 * @template T
 *
 * @extends ServiceEntityRepository<Booking>
 */
final class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findAvailableRooms($checkIn, $checkOut, $room)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('b')
            ->from(Booking::class, 'b')
            ->andWhere('b.checkIn BETWEEN :checkIn AND :checkOut OR b.checkOut BETWEEN :checkIn AND :checkOut OR :checkIn BETWEEN b.checkIn AND b.checkOut')
            ->andWhere('b.room = :roomId')
            ->setParameter('checkIn', $checkIn)
            ->setParameter('checkOut', $checkOut)
            ->setParameter('roomId', $room)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }
}

