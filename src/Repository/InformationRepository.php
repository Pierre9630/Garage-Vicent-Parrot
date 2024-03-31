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

    public function setActiveInformation(Information $information, bool $active): Information
    {
        // Unset all active informations Désactiver toutes les informations actives
        $this->createQueryBuilder('i')
            ->update(Information::class, 'i')
            ->set('i.active', ':active')
            // Condition to update only active information pour ne mettre à jour que les informations actives
            ->where('i.active = :true')
            // New value for active field La nouvelle valeur du champ 'active' (false pour désactiver)
            ->setParameter('active', false)
            // Actual value of active field for WHERE condition La valeur actuelle du champ 'active' pour la condition
            // WHERE
            ->setParameter('true', true)
            ->getQuery()
            ->execute();

        // Activate or deastivate specified line Activer ou désactiver la ligne spécifiée
        $information->setActive($active);
        $this->_em->persist($information);
        $this->_em->flush();

        return $information;
    }

    public function findActiveInformation(): ?Information
    {
        return $this->findOneBy(['active' => true]);
    }

}
