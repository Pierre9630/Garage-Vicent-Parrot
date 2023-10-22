<?php

namespace App\Repository;

use App\Entity\Contacts;
use App\Entity\Offers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offers>
 *
 * @method Offers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offers[]    findAll()
 * @method Offers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offers::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function generateReference(): string
    {
        $today = new \DateTimeImmutable();
        $month = $today->format('m'); // Mois sous forme de deux chiffres
        $day = $today->format('d');   // Jour sous forme de deux chiffres
        $year = $today->format('y'); // Année sous forme de deux chiffres

        // Récupérez le dernier numéro de référence pour la journée actuelle
        $lastReference = $this->getLastReferenceForToday($today);
        //dump($today);
        //dd($lastReference);
        // Incrémentation du dernier numéro de référence
        $incrementedReference = str_pad($lastReference + 1, 3, '0', STR_PAD_LEFT);
        //dd($incrementedReference);
        // Créer la référence complète
        return "A{$year}{$month}{$day}{$incrementedReference}";
    }

    /**
     * @throws NonUniqueResultException
     */
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
        return "A{$month}{$day}{$incrementedReference}";
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
            ->where('o.created_at BETWEEN :startDate AND :endDate')
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
    public function paginateOffers(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    }

    public function findByFilters(string $keyword, ?int $minPrice, ?int $maxPrice, ?int $maxKilometers)
    {
        $query = $this->createQueryBuilder('o')
            ->andWhere('o.offer_title LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%');

        if ($minPrice !== null) {
            $query->andWhere('o.car.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->andWhere('o.car.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if ($maxKilometers !== null) {
            $query->andWhere('o.car.kilometers <= :maxKilometers')
                ->setParameter('maxKilometers', $maxKilometers);
        }

        return $query->getQuery()->getResult();
    }
    public function findApprovedContactsForOffer(Offers $offer)
    {
        return $this->createQueryBuilder('o')
            ->select('c')
            ->from(Contacts::class, 'c')
            ->where('c.offer = :offer')
            ->andWhere('c.isApproved = true')
            ->setParameter('offer', $offer)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Offers[] Returns an array of Offers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offers
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
