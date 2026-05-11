# Documentation technique – Application "Suivi des stages" (BTS SIO – SLAM)

## 1. Présentation générale

L’application « Suivi des stages » est un outil web développé avec Symfony permettant de gérer l’ensemble du cycle de suivi des stages des étudiants de BTS SIO : référentiels (étudiants, entreprises), stages, affectations des professeurs, mise à jour des statuts de documents, vue de pilotage « Suivi & visites », tableau de bord et exports CSV/Excel.

L’application est destinée à trois profils principaux :
- **Administrateur** : paramétrage des référentiels, gestion des stages, affectations, pilotage global, exports.
- **Enseignant** : consultation des stages qui lui sont affectés, mise à jour des statuts, suivi de ses visites.
- **Secrétariat / direction** : consultation/exports des données pour relances et archivage.

---

## 2. Architecture logicielle

### 2.1. Technologies principales

- **Langage** : PHP 8.2.18
- **Framework** : Symfony 5.10.4
- **Vues** : Twig
- **Base de données** : MySQL / MariaDB
- **ORM** : Doctrine
- **Front-end** : HTML5, CSS3, framework CSS , icônes 
- **Gestion de versions** : Git (GitHub)

### 2.2. Organisation des couches

- **Couche présentation** : templates Twig, contrôleurs Symfony, formulaires, validations.
- **Couche métier** : services de domaine (gestion des statuts, calcul des indicateurs, filtrage des stages, etc.).
- **Couche accès données** : entités Doctrine + repositories (requêtes personnalisées pour filtrage et exports).

### 2.3. Arborescence principale (simplifiée)

- `src/`
  - `Controller/`
    - `SecurityController.php` : authentification (login/logout).
    - `DashboardController.php` : tableau de bord.
    - `EtudiantController.php` : gestion des étudiants (CRUD + archivage).
    - `EntrepriseController.php` : gestion des entreprises (CRUD).
    - `StageController.php` : gestion des stages (création / modification).
    - `SuiviController.php` : vue « Suivi & visites » et filtrage.
    - `ExportController.php` : exports CSV/Excel (étudiants, entreprises, stages).
  - `Entity/` : entités Doctrine (Utilisateur, Etudiant, Entreprise, Stage, Visite, Historique, etc.).
  - `Repository/` : classes de repository Doctrine, avec méthodes de filtrage et d’export.
  - `Security/` : classes liées à la sécurité (authenticator, gestion des rôles).
- `templates/` : vues Twig (accueil, listes, formulaires, tableau de bord, exports…).
- `migrations/` : scripts de migration Doctrine pour la base de données.
- `public/` : ressources publiques (CSS, JS, images).

---

## 3. Modèle de données (entités principales)

### 3.1. Entité Utilisateur

Représente un compte de connexion (enseignant ou administrateur).

Champs principaux :
- `id` (int, PK)
- `email` (string, unique)
- `password` (string, hashé)
- `roles` (json, ex. `["ROLE_ADMIN"]`, `["ROLE_TEACHER"]`)
- `nom` (string)
- `prenom` (string)
- éventuellement `isActive` (bool)

Règles de gestion :
- L’email est unique et sert d’identifiant de connexion.
- Le mot de passe est stocké de façon chiffrée (PasswordHasher Symfony).

### 3.2. Entité Etudiant

- `id` (int, PK)
- `nom` (string)
- `prenom` (string)
- `filiere` (string, valeurs attendues : `SLAM` ou `SISR`)
- `promotion` (string ou int)
- `email` (string, optionnel)
- `telephone` (string, optionnel)
- `isArchived` (bool)

Règles de gestion :
- Nom, prénom, filière et promotion sont obligatoires.
- Un étudiant archivé n’est plus proposé pour la création de nouveaux stages mais reste visible dans l’historique.

### 3.3. Entité Entreprise

- `id` (int, PK)
- `nom` (string)
- `adresse` (string)
- `codePostal` (string)
- `ville` (string)
- `email` (string)
- `telephone` (string)
- `tuteurNom` (string, optionnel)

Règles de gestion :
- Nom, ville et coordonnées (au minimum email ou téléphone) sont requis.
- L’email doit respecter un format valide.

### 3.4. Entité Stage

- `id` (int, PK)
- `etudiant` (ManyToOne → Etudiant)
- `entreprise` (ManyToOne → Entreprise)
- `dateDebut` (date)
- `dateFin` (date)
- `profSuivi` (ManyToOne → Utilisateur, null possible)
- `profVisite` (ManyToOne → Utilisateur, null possible)
- `statutAttestation` (string, ex. `Non saisi`, `En cours`, `Reçue`, `Validée`)
- `remarques` (text, optionnel)

Règles de gestion :
- `dateFin` ≥ `dateDebut`.
- `etudiant` et `entreprise` sont obligatoires.
- Le statut d’attestation est initialisé à « Non saisi » ou `NULL`.

### 3.5. Entité Historique

Permet de tracer les modifications importantes (ex. changements de statuts, d’affectations).

- `id` (int, PK)
- `stage` (ManyToOne → Stage)
- `auteur` (ManyToOne → Utilisateur)
- `type` (string, ex. `STATUT`, `AFFECTATION`)
- `description` (text)
- `dateCreation` (datetime)

Règles :
- Un enregistrement est ajouté à chaque changement de statut ou d’affectation.

(Des entités supplémentaires peuvent exister pour modéliser plus finement les visites ou les documents.)

---

## 4. Flux fonctionnels principaux

### 4.1. Authentification (UC-01)

1. L’utilisateur accède à `/login`.
2. Il saisit son email et son mot de passe.
3. Symfony Security vérifie les identifiants.
4. En cas de succès, la session est ouverte et l’utilisateur est redirigé vers l’accueil / le tableau de bord.
5. En cas d’échec, un message d’erreur est affiché.

### 4.2. Gestion des étudiants (UC-02)

- Liste des étudiants : pagination et recherche (nom, filière, promotion).
- Ajout / modification via un formulaire Symfony (validation côté serveur).
- Archivage : changement du booléen `isArchived`.

### 4.3. Gestion des entreprises (UC-03)

- Liste des entreprises avec filtre par ville ou secteur (si champ prévu).
- Ajout / modification via formulaires.

### 4.4. Gestion des stages (UC-04, UC-06)

- Création : sélection d’un étudiant, d’une entreprise, saisie des dates et remarques.
- Affectation des professeurs de suivi / visite sur la fiche stage (UC-06).
- Chaque modification significative (affectations, statuts) génère une entrée dans l’historique.

### 4.5. Mise à jour des statuts (UC-07)

- Accès depuis la fiche stage ou depuis la vue « Suivi & visites ».
- L’enseignant (ou l’admin) modifie un ou plusieurs statuts de documents (ex. `Attestation = Reçue`).
- Le système valide les valeurs et enregistre :
  - le nouveau statut dans l’entité `Stage` (ou une entité dédiée),
  - une entrée dans `Historique`.

### 4.6. Vue « Suivi & visites » (UC-08)

- Affiche une liste des stages avec informations clés (étudiant, entreprise, dates, profs, statuts).
- Filtres disponibles : promotion, filière, entreprise, professeur, statut, etc.
- Règle de sécurité :
  - Administrateur → voit tous les stages.
  - Enseignant → voit uniquement les stages où il est `profSuivi` ou `profVisite`.

### 4.7. Tableau de bord (UC-10)

- Récupération des indicateurs via des requêtes d’agrégation (requetes Doctrine ou SQL brut) :
  - nombre d’étudiants, nombre de stages, répartition SLAM/SISR, nombre de stages en cours, etc.
- Génération de données pour les graphiques (évolution, répartition par filière, stages par entreprise…).

---

## 5. Sécurité et gestion des rôles

- Authentification gérée par Symfony Security (`security.yaml`).
- Utilisation d’un authenticator custom ou du système de login form Symfony.
- Rôles :
  - `ROLE_ADMIN` : accès complet à la configuration, aux référentiels, aux exports.
  - `ROLE_TEACHER` : accès aux stages qui lui sont affectés, mise à jour des statuts.
- Contrôle d’accès :
  - via annotations / attributs PHP (`#[IsGranted('ROLE_ADMIN')]`) sur les contrôleurs ou méthodes.
  - via la configuration `access_control` dans `security.yaml`.

Des voters Symfony peuvent être ajoutés pour gérer des règles fines (ex. un enseignant ne peut mettre à jour que les stages qui lui sont affectés).

---

## 6. Routes principales (exemple)

| Route                     | Méthode(s) | Contrôleur/Action                 | Rôle requis        | Description                                  |
|---------------------------|-----------|-----------------------------------|--------------------|----------------------------------------------|
| `/login`                  | GET/POST  | `SecurityController::login`       | Public             | Authentification                             |
| `/logout`                 | GET       | `SecurityController::logout`      | Authentifié        | Déconnexion                                  |
| `/`                       | GET       | `DashboardController::index`      | Admin/Teacher      | Tableau de bord                              |
| `/etudiants`              | GET       | `EtudiantController::index`       | Admin              | Liste des étudiants                          |
| `/etudiants/new`          | GET/POST  | `EtudiantController::new`         | Admin              | Création d’un étudiant                       |
| `/entreprises`            | GET       | `EntrepriseController::index`     | Admin              | Liste des entreprises                        |
| `/stages`                 | GET       | `StageController::index`          | Admin              | Liste des stages                             |
| `/stages/new`             | GET/POST  | `StageController::new`            | Admin              | Création d’un stage                          |
| `/suivi`                  | GET       | `SuiviController::index`          | Admin/Teacher      | Vue « Suivi & visites »                      |
| `/admin/exports`          | GET       | `ExportController::index`         | Admin              | Page d’exports                               |
| `/admin/exports/etudiants`| GET       | `ExportController::exportEtudiants`| Admin             | Export CSV des étudiants                     |
| `/admin/exports/entreprises`| GET     | `ExportController::exportEntreprises`| Admin           | Export CSV des entreprises                   |
| `/admin/exports/stages`   | GET       | `ExportController::exportStages`  | Admin              | Export CSV/Excel des stages                  |

(Les noms exacts des routes peuvent varier selon ton implémentation.)

---

## 7. Module d’export CSV / Excel

### 7.1. Principe technique

- Utilisation d’une `StreamedResponse` Symfony pour écrire le CSV directement dans le flux `php://output`.
- Ajout d’un BOM UTF-8 (`"ï»¿"`) pour éviter les problèmes d’accents sous Excel.
- Séparateur `;` pour correspondre au paramétrage régional français.

### 7.2. Exemple de méthode d’export des stages

```php
#[Route('/admin/stages/export', name: 'app_export_stages_csv')]
public function exportStagesCsv(Request $request, StageRepository $stageRepository): StreamedResponse
{
    // Récupération des filtres éventuels (vue Suivi & visites)
    $filters = $request->query->all();

    $stages = $stageRepository->findFilteredStages($filters);

    $response = new StreamedResponse(function () use ($stages) {
        $handle = fopen('php://output', 'w+');
        // BOM UTF-8
        fputs($handle, "ï»¿");

        // En-têtes CSV
        fputcsv($handle, [
            'ID Stage', 'Étudiant', 'Filière', 'Entreprise', 'Ville',
            'Date début', 'Date fin', 'Prof Suivi', 'Prof Visite', 'Attestation'
        ], ';');

        foreach ($stages as $stage) {
            $etudiant = $stage->getEtudiant();
            $entreprise = $stage->getEntreprise();
            $profSuivi = $stage->getProfSuivi();
            $profVisite = $stage->getProfVisite();

            fputcsv($handle, [
                $stage->getId(),
                $etudiant ? $etudiant->getNom() . ' ' . $etudiant->getPrenom() : 'N/A',
                $etudiant ? $etudiant->getFiliere() : 'N/A',
                $entreprise ? $entreprise->getNom() : 'N/A',
                $entreprise ? $entreprise->getVille() : 'N/A',
                $stage->getDateDebut() ? $stage->getDateDebut()->format('d/m/Y') : '',
                $stage->getDateFin() ? $stage->getDateFin()->format('d/m/Y') : '',
                $profSuivi ? $profSuivi->getNom() . ' ' . $profSuivi->getPrenom() : 'Non assigné',
                $profVisite ? $profVisite->getNom() . ' ' . $profVisite->getPrenom() : 'Non assigné',
                $stage->getStatutAttestation() ?? 'Non saisi'
            ], ';');
        }

        fclose($handle);
    });

    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="stages_' . date('Ymd_His') . '.csv"');

    return $response;
}
```

### 7.3. Gestion des filtres côté repository

```php
public function findFilteredStages(array $filters): array
{
    $qb = $this->createQueryBuilder('s')
        ->leftJoin('s.etudiant', 'e')
        ->leftJoin('s.entreprise', 'ent')
        ->addSelect('e', 'ent');

    if (!empty($filters['filiere'])) {
        $qb->andWhere('e.filiere = :filiere')
           ->setParameter('filiere', $filters['filiere']);
    }

    if (!empty($filters['promotion'])) {
        $qb->andWhere('e.promotion = :promotion')
           ->setParameter('promotion', $filters['promotion']);
    }

    if (!empty($filters['statut'])) {
        $qb->andWhere('s.statutAttestation = :statut')
           ->setParameter('statut', $filters['statut']);
    }

    // Autres filtres possibles : entreprise, professeur, période, etc.

    return $qb->getQuery()->getResult();
}
```

---

## 8. Environnement de développement & déploiement

### 8.1. Développement local

- Lancement du serveur Symfony (`symfony serve`) ou serveur PHP intégré.
- Base de données locale MySQL/MariaDB.
- Utilisation d’un fichier `.env.local` pour les paramètres sensibles.

### 8.2. Déploiement (piste)

- Hébergement possible sur un mutualisé compatible Symfony, un VPS ou une plateforme type Heroku / Railway / autres.
- Étapes principales :
  - déploiement du code via Git (pull ou CI/CD) ;
  - installation des dépendances (`composer install --no-dev`) ;
  - exécution des migrations Doctrine ;
  - configuration du `APP_ENV=prod` et du `APP_SECRET` ;
  - configuration du virtual host ou reverse proxy vers `public/index.php`.

---

## 9. Pistes d'amélioration technique

- Ajout de tests automatisés (PHPUnit, tests fonctionnels avec Symfony Panther ou BrowserKit).
- Mise en place d’un système de notifications (emails) pour les relances d’attestations ou de bilans non remis.
- Gestion plus fine des documents (upload, stockage sécurisé, génération de PDF).
- Ajout d’une API REST (ou GraphQL) pour interagir avec des outils externes.
- Intégration d’un système de logs centralisés (Monolog avec canaux dédiés pour les erreurs métier).

---

Ce document sert de référence technique globale pour la maintenance, l’évolution du projet et la préparation de l’épreuve E6 (partie technique).
