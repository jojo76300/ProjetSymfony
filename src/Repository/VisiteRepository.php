<?php
// src/Repository/VisiteRepository.php
namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    public function findAllForSuivi(): array
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.stage', 's')->addSelect('s')
            ->leftJoin('s.etudiant', 'e')->addSelect('e')
            ->leftJoin('s.entreprise', 'ent')->addSelect('ent')
            ->leftJoin('v.enseignantVisiteur', 'ens')->addSelect('ens')
            ->orderBy('v.dateVisite', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
