<?php

namespace App\Repository;

use App\Entity\Information;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Information>
 *
 * @method Information|null find($id, $lockMode = null, $lockVersion = null)
 * @method Information|null findOneBy(array $criteria, array $orderBy = null)
 * @method Information[]    findAll()
 * @method Information[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Information::class);
    }

    public function setActiveInformation(Information $information): Information
    {
        // Désactiver toutes les informations actives
        $this->createQueryBuilder('i')
            ->update(Information::class, 'i')
            ->set('i.active', ':active')
            ->where('i.active = :true')
            ->setParameter('active', false)
            ->setParameter('true', true)
            ->getQuery()
            ->execute();

        // Activer la ligne spécifiée
        $information->setActive(true);
        $this->_em->persist($information);
        $this->_em->flush();
        return $information;
    }

    public function findActiveInformation(): ?Information
    {
        return $this->findOneBy(['active' => true]);
    }

//    /**
//     * @return Information[] Returns an array of Information objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Information
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
