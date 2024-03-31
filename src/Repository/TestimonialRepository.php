<?php

namespace App\Repository;

use App\Entity\Testimonial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Testimonial>
 *
 * @method Testimonial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testimonial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testimonial[]    findAll()
 * @method Testimonial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestimonialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testimonial::class);
    }
    public function findNotApproved()
    {
        return $this->createQueryBuilder('t')
            ->where('t.isApproved = :approved')
            ->setParameter('approved', 0)
            ->getQuery()
            ->getResult();
    }

    public function findApprovedTestimonials()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.isApproved = :approved')
            ->setParameter('approved', 1)
            ->getQuery()
            ->getResult();
    }
    public function paginateTestimonials(): Query
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    }

}
