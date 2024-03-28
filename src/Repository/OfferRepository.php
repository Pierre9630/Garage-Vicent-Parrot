<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offer>
 *
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function generateReference(): string
    {
        $today = new \DateTimeImmutable();
        $month = $today->format('m'); // Month on 2 digit form Mois sous forme de deux chiffres
        $day = $today->format('d');   // Day on 2 digit form Jour sous forme de deux chiffres
        $year = $today->format('y'); // Year on 2 digit form Année sous forme de deux chiffres

        // Get latest reference number Récupérez le dernier numéro de référence pour la journée actuelle
        $lastReference = $this->getLastReferenceForToday();
        //dump($today);
        //dd($lastReference);
        // Increment latest reference number Incrémentation du dernier numéro de référence
        $incrementedReference = str_pad($lastReference + 1, 3, '0', STR_PAD_LEFT);
        //dd($incrementedReference);
        // Create complete reference Créer la référence complète
        return "A{$year}{$month}{$day}{$incrementedReference}";
    }

    /**
     * @throws NonUniqueResultException
     */
    public function generateReferenceForDate(\DateTimeImmutable $date): string
    {
        //$today = new \DateTimeImmutable();
        $month = $date->format('m'); // Month on 2 digit form Mois sous forme de deux chiffres
        $day = $date->format('d');   // Day on 2 digit form Jour sous forme de deux chiffres

        // Get latest reference number for today Récupérez le dernier numéro de référence pour la journée actuelle
        $lastReference = $this->getLastReferenceForToday();
        //dump($date);

        // Increment latest reference number Incrémentation du dernier numéro de référence
        $incrementedReference = str_pad($lastReference + 1, 3, '0', STR_PAD_LEFT);

        // Create complete reference Créez la référence complète
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

        // If not reference for today return 0 S'il n'y a pas de référence pour aujourd'hui retourne 0.
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
    public function findApprovedContactsForOffer(Offer $offer)
    {
        return $this->createQueryBuilder('o')
            ->select('c')
            ->from(Contact::class, 'c')
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
