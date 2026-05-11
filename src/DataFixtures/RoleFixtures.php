<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const ROLE_ADMIN_REF = 'role_admin';
    public const ROLE_TEACHER_REF = 'role_teacher';

    public function load(ObjectManager $manager): void
    {
        // id = 1 : Administrateur
        $admin = new Role();
        $admin->setLibelle('Administrateur');
        $admin->setDescription('Administrateur de l’application');
        $manager->persist($admin);
        $this->addReference(self::ROLE_ADMIN_REF, $admin);

        // id = 2 : Professeur
        $prof = new Role();
        $prof->setLibelle('Professeur');
        $prof->setDescription('Professeur pouvant gérer les stages');
        $manager->persist($prof);
        $this->addReference(self::ROLE_TEACHER_REF, $prof);

        $manager->flush();
    }
}
