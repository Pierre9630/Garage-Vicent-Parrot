<?php

namespace App\Service;
use App\Entity\Car;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;

class SearchService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function searchWithFilters(?string $keyword = null,?string $brand = null, ?int $minPrice = null, ?int $maxPrice = null,?int $minKilometers= null, ?int $maxKilometers= null, ?string $reference): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('o')
            ->from(Offer::class, 'o')
            //->innerJoin(Cars::class,'c','ON','c.offer','c.offer = o.car');
              ->innerJoin('o.car','c');

        if ($keyword) {
            $qb->andWhere('o.offer_title LIKE :keyword')
                ->setParameter('keyword', "%$keyword%");
        }

        if ($brand) {
            $qb->andWhere('c.brand LIKE :brand')
                ->setParameter('brand', "%$brand%");
        }

        if ($minPrice) {
            $qb->andWhere('c.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if ($maxPrice) {
            $qb->andWhere('c.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if ($minKilometers) {
            $qb->andWhere('c.kilometers <= :minKilometers')
                ->setParameter('minKilometers', $minKilometers);
        }

        if ($maxKilometers) {
            $qb->andWhere('c.kilometers <= :maxKilometers')
                ->setParameter('maxKilometers', $maxKilometers);
        }

        if ($reference) {
            $qb->andWhere('o.reference LIKE :reference')
                ->setParameter('reference', "%$reference%");
        }
        return $qb->getQuery()->getResult();
    }
}