-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 11, 2026 at 10:01 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gkvstage`
--

-- --------------------------------------------------------

--
-- Table structure for table `affectation`
--

DROP TABLE IF EXISTS `affectation`;
CREATE TABLE IF NOT EXISTS `affectation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_affectation` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stage_id` int NOT NULL,
  `enseignant_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F4DD61D32298D193` (`stage_id`),
  KEY `IDX_F4DD61D3E455FCC0` (`enseignant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `avoir`
--

DROP TABLE IF EXISTS `avoir`;
CREATE TABLE IF NOT EXISTS `avoir` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_659B1A43FB88E14F` (`utilisateur_id`),
  KEY `IDX_659B1A43D60322AC` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `avoir`
--

INSERT INTO `avoir` (`id`, `utilisateur_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 2),
(5, 6, 1),
(6, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `entreprise`
--

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secteur` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entreprise`
--

INSERT INTO `entreprise` (`id`, `nom`, `ville`, `secteur`, `contact`, `email`) VALUES
(1, 'Capgemini', 'Paris', 'ESN', 'M. Dubois', 'contact@capgemini.fr'),
(2, 'Orange Business', 'Lyon', 'Télécom/IT', 'Mme. Leroy', 'rh@orange.fr'),
(3, 'Atos', 'Bordeaux', 'Développement', 'M. Roux', 'stages@atos.net'),
(4, 'WebAgency 76', 'Rouen', 'Agence Web', 'Mme. Petit', 'hello@webagency76.fr'),
(5, 'Free', 'Rouen', 'Réseau&Télecom', 'M.Arnaud', 'free@contact.com');

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filiere` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_archived` tinyint NOT NULL,
  `promotion_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_717E22E3139DF194` (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `etudiant`
--

INSERT INTO `etudiant` (`id`, `nom`, `prenom`, `filiere`, `is_archived`, `promotion_id`) VALUES
(1, 'Moreau', 'Lucas', 'SLAM', 0, 1),
(2, 'Simon', 'Chloé', 'SISR', 0, 2),
(3, 'Laurent', 'Hugo', 'SLAM', 0, 1),
(4, 'Michel', 'Emma', 'SLAM', 0, 3),
(5, 'Garcia', 'Thomas', 'SISR', 0, 2),
(6, 'Kamguia', 'jordan', 'SLAM', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `auteur_id` int NOT NULL,
  `stage_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EDBFD5EC60BB6FE6` (`auteur_id`),
  KEY `IDX_EDBFD5EC2298D193` (`stage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `historique`
--

INSERT INTO `historique` (`id`, `action`, `date_creation`, `auteur_id`, `stage_id`) VALUES
(1, 'Création du dossier de stage', '2026-05-01 10:00:00', 1, 1),
(2, 'Changement de statut de l\'attestation : passé à \'En cours\'', '2026-05-02 11:30:00', 2, 1),
(3, 'Planification d\'une visite le 10/06/2026', '2026-05-04 14:15:00', 3, 1),
(4, 'Création du dossier de stage', '2026-01-02 09:00:00', 1, 3),
(5, 'Changement de statut de l\'attestation : passé à \'Reçue\'', '2026-03-01 16:45:00', 4, 3),
(6, 'Planification d\'une visite le 13/05/2026', '2026-05-05 07:48:47', 1, 1),
(7, 'Planification d\'une visite le 07/05/2026', '2026-05-05 07:49:04', 1, 4),
(8, 'Changement de statut de l\'attestation : passé à \'Reçue\'', '2026-05-05 07:49:23', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `classe` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut_stage_defaut` date NOT NULL,
  `date_fin_stage_defaut` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`id`, `classe`, `session`, `date_debut_stage_defaut`, `date_fin_stage_defaut`) VALUES
(1, 'BTS SIO 1 - SLAM', '2025-2026', '2026-05-18', '2026-06-26'),
(2, 'BTS SIO 1 - SISR', '2025-2026', '2026-05-18', '2026-06-26'),
(3, 'BTS SIO 2 - SLAM', '2025-2026', '2026-01-05', '2026-02-27'),
(4, 'BTS SIO 1CIEL', '20252026', '2026-01-01', '2026-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle_symfony` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `libelle`, `description`, `libelle_symfony`) VALUES
(1, 'Administrateur', 'Accès total à l\'application', 'ROLE_ADMIN'),
(2, 'Enseignant', 'Peut gérer ses étudiants et ses visites', 'ROLE_USER');

-- --------------------------------------------------------

--
-- Table structure for table `stage`
--

DROP TABLE IF EXISTS `stage`;
CREATE TABLE IF NOT EXISTS `stage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `remarques` longtext COLLATE utf8mb4_unicode_ci,
  `statut_attestation` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Non saisi',
  `etudiant_id` int NOT NULL,
  `entreprise_id` int NOT NULL,
  `prof_suivi_id` int DEFAULT NULL,
  `prof_visite_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C27C9369DDEAB1A3` (`etudiant_id`),
  KEY `IDX_C27C9369A4AEAFEA` (`entreprise_id`),
  KEY `IDX_C27C9369D5073BAA` (`prof_suivi_id`),
  KEY `IDX_C27C93696C08B97D` (`prof_visite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stage`
--

INSERT INTO `stage` (`id`, `date_debut`, `date_fin`, `remarques`, `statut_attestation`, `etudiant_id`, `entreprise_id`, `prof_suivi_id`, `prof_visite_id`) VALUES
(1, '2026-05-18', '2026-06-26', 'Stage axé sur Symfony', 'En cours', 1, 4, 2, 3),
(2, '2026-05-18', '2026-06-26', 'Réseaux et Sécurité', 'Validée', 2, 2, 4, 4),
(3, '2026-01-05', '2026-02-27', 'Développement C# / MAUI', 'Reçue', 4, 1, 2, 4),
(4, '2026-05-18', '2026-06-26', 'En attente de convention', 'Reçue', 3, 3, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1D1C63B3E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `email`, `mdp`, `status`) VALUES
(1, 'Admin', 'Super', 'admin@admin.fr', '$2y$13$QrKIzChs2f8mVqrxg5qYLOxI.u8Sm6dj0igg1s25IcfZ5XzpAGR1W', 1),
(2, 'Dupont', 'Jean', 'j.dupont@ecole.fr', '$2y$13$XPDLkfGLNnk0ywkC5LGWx.vDsVptzSEYrCttFzrLmvIYcH7Zad7C2', 1),
(3, 'Martin', 'Sophie', 's.martin@ecole.fr', '$2y$13$XPDLkfGLNnk0ywkC5LGWx.vDsVptzSEYrCttFzrLmvIYcH7Zad7C2', 1),
(4, 'Lefebvre', 'Marc', 'm.lefebvre@ecole.fr', '$2y$13$XPDLkfGLNnk0ywkC5LGWx.vDsVptzSEYrCttFzrLmvIYcH7Zad7C2', 1),
(5, 'Barranger', 'Cathy', 'focba@cba.fr', '$2y$13$QELGMypvrfVlSMsQJc.7j.2bzU6VNTdpo8TgEBIkxKyRw23QmmwJy', 1),
(6, 'Barranger', 'catherine', 'bocba@cba.fr', '$2y$13$QELGMypvrfVlSMsQJc.7j.2bzU6VNTdpo8TgEBIkxKyRw23QmmwJy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `visite`
--

DROP TABLE IF EXISTS `visite`;
CREATE TABLE IF NOT EXISTS `visite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_visite` date NOT NULL,
  `commentaires` longtext COLLATE utf8mb4_unicode_ci,
  `stage_id` int NOT NULL,
  `enseignant_visiteur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B09C8CBB2298D193` (`stage_id`),
  KEY `IDX_B09C8CBBED520701` (`enseignant_visiteur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visite`
--

INSERT INTO `visite` (`id`, `date_visite`, `commentaires`, `stage_id`, `enseignant_visiteur_id`) VALUES
(1, '2026-06-10', 'Visite prévue en distanciel via Teams', 1, 3),
(2, '2026-02-15', 'Très bon stage, tuteur très satisfait. L\'étudiante est autonome.', 3, 4),
(3, '2026-05-13', NULL, 1, 2),
(4, '2026-05-07', NULL, 4, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affectation`
--
ALTER TABLE `affectation`
  ADD CONSTRAINT `FK_F4DD61D32298D193` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`),
  ADD CONSTRAINT `FK_F4DD61D3E455FCC0` FOREIGN KEY (`enseignant_id`) REFERENCES `utilisateur` (`id`);

--
-- Constraints for table `avoir`
--
ALTER TABLE `avoir`
  ADD CONSTRAINT `FK_659B1A43D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `FK_659B1A43FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Constraints for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `FK_717E22E3139DF194` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`);

--
-- Constraints for table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `FK_EDBFD5EC2298D193` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`),
  ADD CONSTRAINT `FK_EDBFD5EC60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `utilisateur` (`id`);

--
-- Constraints for table `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `FK_C27C93696C08B97D` FOREIGN KEY (`prof_visite_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_C27C9369A4AEAFEA` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`id`),
  ADD CONSTRAINT `FK_C27C9369D5073BAA` FOREIGN KEY (`prof_suivi_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_C27C9369DDEAB1A3` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiant` (`id`);

--
-- Constraints for table `visite`
--
ALTER TABLE `visite`
  ADD CONSTRAINT `FK_B09C8CBB2298D193` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`),
  ADD CONSTRAINT `FK_B09C8CBBED520701` FOREIGN KEY (`enseignant_visiteur_id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
