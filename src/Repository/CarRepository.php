<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);

    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /*public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $cars = $this->createQueryBuilder('p')
            ->where('p.brand LIKE :brand')
            ->setParameter('brand',$searchData['brand'])
            ->orWhere('p.model LIKE :model')
            ->setParameter('model',$searchData['model'])
            ->orWhere('p.description LIKE :description')
            ->setParameter('description',$searchData['description'])
            ->orWhere('p.TypeFuel LIKE :TypeFuel')
            ->setParameter('TypeFuel',$searchData['TypeFuel'])
            ->orWhere('p.Year LIKE :Year')
            ->setParameter('Year',$searchData['Year'])
            ->orWhere('p.kilometers LIKE :kilometers')
            ->setParameter('kilometers',$searchData['kilometers']);
        return $cars->getQuery()->getResult();
    }*/

    public function paginateCars(): Query
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    }
    public function generateReference(): string
    {
        $today = new \DateTimeImmutable();
        $month = $today->format('m'); // Mois sous forme de deux chiffres
        $day = $today->format('d');   // Jour sous forme de deux chiffres
        $year = $today->format('y'); // Année sous forme de deux chiffres

        // Récupérez le dernier numéro de référence pour la journée actuelle
        $lastReference = $this->getLastReferenceForToday($today);
        //dump($today);

        // Incrémentation du dernier numéro de référence
        $incrementedReference = str_pad($lastReference + 1, 3, '0', STR_PAD_LEFT);

        // Créez la référence complète
        return "C{$year}{$month}{$day}{$incrementedReference}";
    }
    public function generateReferenceForDate(\DateTimeImmutable $date): string
    {
        //$today = new \DateTimeImmutable();
        $month = $date->format('m'); // Mois sous forme de deux chiffres
        $day = $date->format('d');   // Jour sous forme de deux chiffres

        // Récupérez le dernier numéro de référence pour la journée actuelle
        $lastReference = $this->getLastReferenceForToday($date);
        //dump($date);

        // Incrémentation du dernier numéro de référence
        $incrementedReference = str_pad($lastReference + 1, 3, '0', STR_PAD_LEFT);

        // Créez la référence complète
        return "C{$month}{$day}{$incrementedReference}";
    }


    /**
     * @throws NonUniqueResultException
     */
    public function getLastReferenceForToday(): int
    {
        $today = new \DateTimeImmutable();
        $startDate = new \DateTime($today->format('Y-m-d 00:00:00'));
        $endDate = new \DateTime($today->format('Y-m-d 23:59:59'));

        $queryBuilder = $this->createQueryBuilder('o')
            ->select('MAX(SUBSTRING(o.reference, 10)) AS lastReference')
            ->where('o.createdAt BETWEEN :startDate AND :endDate')
            //->andWhere('o.created_at <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery();

        $result = $queryBuilder->getOneOrNullResult();

        if ($result && $lastReference = $result['lastReference']) {
            return (int)$lastReference;
        }

        // S'il n'y a pas de référence pour aujourd'hui retourne 0.
        return 0;
    }
//    /**
//     * @return Cars[] Returns an array of Cars objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cars
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
