<?php
namespace App\Service;

use App\Entity\Historique;
use App\Entity\Stage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class TraceabiliteService
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security
    ) {}

    public function logAction(Stage $stage, string $actionDescription): void
    {
        $historique = new Historique();
        $historique->setAction($actionDescription);
        $historique->setDateCreation(new \DateTime());
        $historique->setAuteur($this->security->getUser());
        $historique->setStage($stage);

        $this->em->persist($historique);
        $this->em->flush();
    }
}