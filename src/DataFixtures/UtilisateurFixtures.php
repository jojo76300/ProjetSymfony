<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    public const ADMIN_REF = 'user_admin';
    public const PROF_REF  = 'user_prof';

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Administrateur (id = 1)
        $admin = new Utilisateur();
        $admin->setEmail('admin@lycee.com');
        $admin->setStatus(true);

        $password = $this->hasher->hashPassword($admin, 'admin');
        $admin->setMdp($password);

        $manager->persist($admin);
        $this->addReference(self::ADMIN_REF, $admin);

        // Professeur (id = 2)
        $prof = new Utilisateur();
        $prof->setEmail('prof@lycee.com');
        $prof->setStatus(true);

        $password = $this->hasher->hashPassword($prof, 'prof');
        $prof->setMdp($password);

        $manager->persist($prof);
        $this->addReference(self::PROF_REF, $prof);

        $manager->flush();
    }
}
