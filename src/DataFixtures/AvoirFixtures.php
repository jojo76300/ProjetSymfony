<?php

namespace App\DataFixtures;

use App\Entity\Avoir;
use App\Entity\Utilisateur;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AvoirFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // admin -> Administrateur
        $a1 = new Avoir();
        $a1->setUtilisateur(
            $this->getReference(UtilisateurFixtures::ADMIN_REF, Utilisateur::class)
        );
        $a1->setRole(
            $this->getReference(RoleFixtures::ROLE_ADMIN_REF, Role::class)
        );
        $manager->persist($a1);

        // prof -> Professeur
        $a2 = new Avoir();
        $a2->setUtilisateur(
            $this->getReference(UtilisateurFixtures::PROF_REF, Utilisateur::class)
        );
        $a2->setRole(
            $this->getReference(RoleFixtures::ROLE_TEACHER_REF, Role::class)
        );
        $manager->persist($a2);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
            RoleFixtures::class,
        ];
    }
}
