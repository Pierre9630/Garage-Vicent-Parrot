<?php

namespace App\Repository;

use App\Entity\OpeningHour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OpeningHour>
 *
 * @method OpeningHour|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpeningHour|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpeningHour[]    findAll()
 * @method OpeningHour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpeningHourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpeningHour::class);
    }

}
