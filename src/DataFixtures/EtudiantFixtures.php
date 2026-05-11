<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtudiantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // On crée un tableau avec les données de test (comme sur la maquette)
        $etudiantsTest = [
            ['nom' => 'Dupont', 'prenom' => 'Marie', 'filiere' => 'SLAM', 'promo' => '2024-2026'],
            ['nom' => 'Martin', 'prenom' => 'Lucas', 'filiere' => 'SISR', 'promo' => '2024-2026'],
            ['nom' => 'Bernard', 'prenom' => 'Sophie', 'filiere' => 'SLAM', 'promo' => '2023-2025'],
            ['nom' => 'Petit', 'prenom' => 'Thomas', 'filiere' => 'SISR', 'promo' => '2024-2026'],
            ['nom' => 'Dubois', 'prenom' => 'Emma', 'filiere' => 'SLAM', 'promo' => '2023-2025'],
            ['nom' => 'Moreau', 'prenom' => 'Hugo', 'filiere' => 'SISR', 'promo' => '2024-2026'],
        ];

        // On boucle sur le tableau pour créer les objets Etudiant
        foreach ($etudiantsTest as $data) {
            $etudiant = new Etudiant();
            $etudiant->setNom($data['nom'])
                     ->setPrenom($data['prenom'])
                     ->setFiliere($data['filiere'])
                     ->setAnnPromotion($data['promo'])
                     ->setIsArchived(false); // Par défaut, non archivé

            // On demande à Doctrine de préparer l'enregistrement
            $manager->persist($etudiant);
        }

        // On crée aussi un étudiant "Archivé" pour tester si le tableau le cache bien
        $etudiantArchive = new Etudiant();
        $etudiantArchive->setNom('Fantôme')
                        ->setPrenom('Gaspard')
                        ->setFiliere('SLAM')
                        ->setAnnPromotion('2020-2022')
                        ->setIsArchived(true); // Celui-ci ne doit pas apparaître dans votre liste !
        $manager->persist($etudiantArchive);

        // On envoie le tout dans la base de données
        $manager->flush();
    }
}
