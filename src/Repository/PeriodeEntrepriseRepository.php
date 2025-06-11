<?php

namespace App\Repository;

use App\Entity\PeriodeEntreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PeriodeEntreprise>
 *
 * @method PeriodeEntreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method PeriodeEntreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method PeriodeEntreprise[]    findAll()
 * @method PeriodeEntreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodeEntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PeriodeEntreprise::class);
    }

    /**
     * Récupère les périodes en entreprise d'une formation spécifique.
     *
     * @param int $formationId
     * @return PeriodeEntreprise[]
     */
    public function findByFormationId(int $formationId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.formation = :formationId')
            ->setParameter('formationId', $formationId)
            ->orderBy('p.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
