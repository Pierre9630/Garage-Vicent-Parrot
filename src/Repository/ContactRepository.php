<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Collection;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function save(Contact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findApprovedComments(Offer $offer)
    {
        return $this->createQueryBuilder('c')
            //->andWhere('c.isApproved = :approved')
            ->where('c.isApproved = :approved')
            ->setParameter('approved', 1)
            ->getQuery()
            ->getResult();
    }
    public function findNotApproved()
    {
        return $this->createQueryBuilder('c')
            ->where('c.isApproved = :approved')
            ->setParameter('approved', 0)
            ->getQuery()
            ->getResult();
    }
    public function paginateContacts(): Query
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    }

}
