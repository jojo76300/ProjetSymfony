<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprise::class);
    }

    /**
     * Retourne toutes les entreprises triées par nom.
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche par texte (nom / ville / secteur).
     */
    public function search(?string $term): array
    {
        if (!$term) {
            return $this->findAllOrdered();
        }

        return $this->createQueryBuilder('e')
            ->andWhere('LOWER(e.nom) LIKE :t
                        OR LOWER(e.ville) LIKE :t
                        OR LOWER(e.secteur) LIKE :t')
            ->setParameter('t', '%'.mb_strtolower($term).'%')
            ->orderBy('e.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
