<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Formation>
 *
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    // Exemple : récupérer les formations actives
    public function findActiveFormations(): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.actif = :val')
            ->setParameter('val', true)
            ->orderBy('f.dateDebut', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // Exemple : trouver formations par état
    public function findByEtat(string $etat): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.etat = :etat')
            ->setParameter('etat', $etat)
            ->orderBy('f.dateDebut', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
