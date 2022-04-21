<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method           findAll()                                                                     array<int, Room>
 * @method           findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) array<array-key, Room>
 *
 * @template T
 *
 * @extends ServiceEntityRepository<Room>
 */
final class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }
}
