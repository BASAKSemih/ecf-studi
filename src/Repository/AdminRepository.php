<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Admin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Admin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Admin|null findOneBy(array $criteria, array $orderBy = null)
 * @method            findAll()                                                                     array<int, Admin>
 * @method            findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) array<array-key, Admin>
 *
 * @template T
 *
 * @extends ServiceEntityRepository<Admin>
 */
final class AdminRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Admin::class);
    }
}
