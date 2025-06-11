<?php

namespace App\Repository;

use App\Entity\Interruption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Interruption>
 *
 * @method Interruption|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interruption|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interruption[]    findAll()
 * @method Interruption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterruptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interruption::class);
    }

    /**
     * Trouve toutes les interruptions d'une formation donnée.
     *
     * @param int $formationId
     * @return Interruption[]
     */
    public function findByFormationId(int $formationId): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.formation = :formationId')
            ->setParameter('formationId', $formationId)
            ->orderBy('i.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
