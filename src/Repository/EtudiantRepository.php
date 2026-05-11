<?php

namespace App\Repository;

use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

    /**
     * Retourne les étudiants actifs triés par nom (ASC ou DESC).
     */
    public function findAllOrderedByNom(string $direction = 'ASC'): array
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

        return $this->createQueryBuilder('e')
            ->andWhere('e.isArchived = :arch')
            ->setParameter('arch', false)
            ->orderBy('e.nom', $direction)
            ->addOrderBy('e.prenom', $direction)
            ->getQuery()
            ->getResult();
    }

    public function countByFiliere(string $filiere): int
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->andWhere('e.filiere = :filiere')
            ->setParameter('filiere', $filiere)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
