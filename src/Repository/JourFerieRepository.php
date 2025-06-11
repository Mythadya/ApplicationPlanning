<?php

namespace App\Repository;

use App\Entity\JourFerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JourFerie>
 *
 * @method JourFerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method JourFerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method JourFerie[]    findAll()
 * @method JourFerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JourFerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JourFerie::class);
    }

    /**
     * Récupère les jours fériés à partir d’une date donnée.
     *
     * @param \DateTimeInterface $startDate
     * @return JourFerie[]
     */
    public function findUpcomingFromDate(\DateTimeInterface $startDate): array
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.date >= :startDate')
            ->setParameter('startDate', $startDate)
            ->orderBy('j.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
