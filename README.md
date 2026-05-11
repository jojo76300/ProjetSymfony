# Suivi des stages – BTS SIO OU AUTRES

Application web de suivi des stages pour les étudiants de BTS SIO et CIEL.  
Elle permet à l'équipe pédagogique et au secrétariat de gérer les étudiants, les entreprises, les stages, les visites, les statuts de documents et d'exporter des rapports pour le pilotage et les archives.

---

## 🧭 Contexte et objectifs

Ce projet a été réalisé dans le cadre du BTS SIO (option SLAM), en 2ᵉ année.  
L'objectif est de remplacer les fichiers Excel manuels par un outil centralisé qui :

- facilite le suivi des stages de chaque étudiant ;
- aide les enseignants à organiser les visites et à mettre à jour les statuts (attestations, bilans, etc.) ;
- permet au secrétariat d’exporter des listes filtrées pour les relances et les archives.

---

## ✨ Fonctionnalités principales

### Authentification & rôles

- Connexion par email / mot de passe (Symfony Security).
- Gestion de rôles : **Administrateur** et **Enseignant**.
- Droits différenciés sur les vues et les actions (affichage des stages, mise à jour des statuts, exports).

### Référentiels

- **Étudiants**  
  - Création, modification, archivage des étudiants (nom, prénom, filière SLAM/SISR, promotion, coordonnées).
- **Entreprises**  
  - Gestion des entreprises partenaires : coordonnées, ville, contact, email, téléphone, tuteur.

### Stages & affectations

- Création / modification des stages :
  - association Étudiant ↔ Entreprise ;
  - période (date de début / fin) et durée.
- Affectation d’un **professeur de suivi** et d’un **professeur de visite** par stage.
- Historisation des changements d’affectation.

### Statuts & suivi

- Mise à jour des statuts de documents et jalons :
  - remerciements, bilan/suivi, jury, attestation, etc.
- Journal d’historique avec date, auteur et valeur de statut (traces consultables).

### Vue « Suivi & visites »

- Vue consolidée des stages avec filtres (promotion, filière, entreprise, professeur, statut…).
- Pour un **Admin** : vision globale de tous les stages.
- Pour un **Enseignant** : uniquement les stages dont il est prof de suivi ou de visite.

### Tableau de bord (Dashboard)

- Indicateurs clés : nombre de stages, répartition par filière, stages en cours, visites à planifier.
- Graphiques (barres / camembert) pour visualiser la répartition et l’avancement.
- Liste des prochaines visites à venir.

### Exports (CSV / Excel / PDF)

Module dédié « Exports » permettant :

- Export de la **liste des étudiants** (CSV ou PDF selon besoin).
- Export de la **liste des entreprises** (CSV).
- Export du **rapport des stages** (CSV/Excel compatible) à partir de la vue filtrée (filtres repris dans l’export).

---

## 🏗️ Stack technique

- **Langage** : PHP 8.2.18
- **Framework** : Symfony 5.10.4
- **Templates** : Twig
- **Base de données** : MySQL 
- **ORM** : Doctrine
- **Frontend** : HTML5, CSS3, ramework CSS, icônes (FontAwesome)
- **Outils** : Composer, Git/GitHub, VS Code 

---

## 📂 Architecture et principales entités

### Entités métier

- `Utilisateur` : comptes des administrateurs et enseignants (email, mot de passe, rôles).
- `Etudiant` : informations des étudiants (nom, prénom, filière, promotion, contact).
- `Entreprise` : informations des entreprises (nom, adresse, ville, contact, email…).
- `Stage` : lien étudiant / entreprise + période + prof de suivi + prof de visite.
- `Visite` (optionnel si utilisé) : informations sur la visite en entreprise.
- `Statut` / champs de statut : attestation, bilan, jury, etc.
- `Historique` : trace des mises à jour importantes (statuts, affectations).

### Organisation du code (exemple)

- `src/Controller/`  
  - `SecurityController.php` : login, logout.  
  - `EtudiantController.php`, `EntrepriseController.php`, `StageController.php` : CRUD référentiels et stages.  
  - `SuiviController.php` : vue « Suivi & visites ».  
  - `DashboardController.php` : tableau de bord.  
  - `ExportController.php` : exports CSV/Excel.

- `src/Entity/` : entités Doctrine (Étudiant, Entreprise, Stage, Utilisateur, etc.).
- `src/Repository/` : requêtes personnalisées (filtres pour Suivi & visites, exports).
- `templates/` : vues Twig (accueil, listes, formulaires, exports…).
- `public/` : ressources publiques (CSS, JS, images).

---

## ⚙️ Installation et configuration

### Prérequis

- PHP 8.2.18
- Composer
- MySQL / MariaDB
- Git

### Étapes

1. **Cloner le dépôt**

```bash
git clone 'https://github.com/jojo76300/ProjetSymfony.git'
cd <PROJETE6-1>
```

2. **Installer les dépendances**

```bash
composer install
```

3. **Configurer la base de données**

Dans `.env` (ou `.env.local`), adapter la variable `DATABASE_URL` :

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/GKVstage?serverVersion=8.3.0"
```

4. **Créer la base et exécuter les migrations**

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. **Charger éventuellement des jeux de données (fixtures)**

```bash
php bin/console doctrine:fixtures:load
```

6. **Lancer le serveur de développement**

```bash
symfony serve
# ou
php -S 127.0.0.1:8000 -t public
```

Accéder à l’application :  
http://127.0.0.1:8000/

---

## 👤 Rôles et accès

- **Administrateur**
  - Gère les étudiants, entreprises et stages.
  - Affecte les professeurs de suivi et de visite.
  - Accède à toutes les vues de suivi, au tableau de bord et aux exports.

- **Enseignant**
  - Consulte les stages qui lui sont attribués.
  - Met à jour les statuts des documents.
  - Accède à une vue filtrée de « Suivi & visites » et à un tableau de bord adapté à son périmètre.

---

## 📤 Module d’export CSV / Excel

### Vue « Exports »

Une page dédiée propose plusieurs cartes :

- **Liste des étudiants**  
  Export de la liste complète des étudiants et de leurs informations (CSV/PDF).

- **Liste des entreprises**  
  Export des entreprises partenaires et de leurs coordonnées (CSV).

- **Rapport des stages**  
  Export des stages (ou de la vue filtrée) au format CSV compatible Excel.

### Implementation (Symfony)

- Utilisation de `StreamedResponse` pour générer le CSV en mémoire sans surcharge.
- Séparateur `;` et BOM UTF‑8 pour compatibilité Excel.
- Les exports de stages peuvent réutiliser les **filtres de la vue Suivi & visites** via les paramètres de requête.

---

## ✅ Tests et validation

Un **cahier de tests** décrit les cas suivants :

- Authentification (succès / échec).
- CRUD étudiants / entreprises.
- Création / modification de stage.
- Affectation des professeurs de suivi / visite.
- Mise à jour des statuts de documents.
- Affichage et filtrage de la vue « Suivi & visites ».
- Exports CSV/Excel (génération, compatibilité Excel, respect des filtres).

Les tests sont réalisés principalement en tests manuels à partir de ce cahier, avec corrections de bugs au fur et à mesure.

---

## 📝 Documentation projet

- Expression des besoins « Suivi des stages BTS SIO » (document fonctionnel initial).
- Backlog des user stories (US‑01 à US‑10).
- Use cases détaillés et illustrés (UC‑01 à UC‑10).
- Cahier de tests fonctionnels.
- Fiche descriptive de réalisation professionnelle (FDRP, épreuve E6).

---

## 🚀 Pistes d’évolutions

- Ajout de notifications (mail) pour les relances de documents non remis.
- Export PDF des conventions, attestations ou synthèses de stage.
- Intégration d’un calendrier des visites synchronisé (Google Calendar / autre).
- Ajout de tests automatisés (PHPUnit, tests fonctionnels Symfony).

---

## 👨‍💻 Auteur

- **Nom / Prénom** : *Kamguia Jordan*  
- **Formation** : BTS SIO – option SLAM – *Campus la Châtaigneraie*  
- **Année** : Session 2026.
