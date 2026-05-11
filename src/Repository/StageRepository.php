<?php
namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    public function findForSuiviVisites($user, array $filters = []): array
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.etudiant', 'e')->addSelect('e')
            ->leftJoin('e.promotion', 'p')->addSelect('p')
            ->leftJoin('s.entreprise', 'ent')->addSelect('ent')
            ->leftJoin('s.profSuivi', 'ps')->addSelect('ps')
            ->leftJoin('s.profVisite', 'pv')->addSelect('pv')
            ->orderBy('p.session', 'DESC')
            ->addOrderBy('e.nom', 'ASC');

        // 1. Restriction d'affichage : si l'utilisateur n'est pas Admin, il ne voit que ses stages
        if (!in_array('ROLE_ADMIN', $user->getRoles())) {
            $qb->andWhere('s.profSuivi = :user OR s.profVisite = :user')
               ->setParameter('user', $user);
        }

        // 2. Filtre par Promotion
        if (!empty($filters['promotion'])) {
            $qb->andWhere('p.id = :promoId')
               ->setParameter('promoId', $filters['promotion']);
        }

        // 3. Filtre par Statut (ex: Attestation)
        if (!empty($filters['statut'])) {
            $qb->andWhere('s.statutAttestation = :statut')
               ->setParameter('statut', $filters['statut']);
        }

        return $qb->getQuery()->getResult();
    }

}
