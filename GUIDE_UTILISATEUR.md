# Guide utilisateur – Application "Suivi des stages" (BTS SIO – SLAM)

## 1. Introduction

Bienvenue dans l’application **Suivi des stages**. Ce guide explique comment utiliser l’outil au quotidien selon votre profil (Administrateur ou Enseignant).

L’application permet de :
- gérer les **étudiants** et les **entreprises** partenaires ;
- créer et suivre les **stages** des étudiants ;
- affecter les **professeurs de suivi** et de **visite** ;
- mettre à jour les **statuts** (attestations, bilans, jury, etc.) ;
- consulter la vue de pilotage **« Suivi & visites »** ;
- exporter des listes au format **CSV/Excel** pour les relances et les archives.

---

## 2. Connexion à l’application

1. Ouvrez votre navigateur (Chrome, Firefox, Edge…).
2. Saisissez l’adresse de l’application dans la barre d’adresse, par exemple :
   - `http://127.0.0.1:8000/` (en local) ou
   - `https://suivi-stages.<domaine>` (en production).
3. Vous arrivez sur la page de **connexion**.
4. Entrez votre **adresse e-mail** et votre **mot de passe**.
5. Cliquez sur le bouton **« Se connecter »**.

En cas d’erreur d’identifiants, un message vous informera que la combinaison e‑mail / mot de passe est incorrecte. Contactez l’administrateur si vous avez oublié vos identifiants.

---

## 3. Profils et droits

### 3.1. Administrateur

L’administrateur dispose de tous les droits sur l’application :
- gestion des **utilisateurs** (si fonction activée) ;
- gestion des **étudiants** et des **entreprises** ;
- création et modification des **stages** ;
- affectation des **professeurs** de suivi et de visite ;
- accès au **tableau de bord** global ;
- accès complet à la vue **« Suivi & visites »** ;
- accès au module **Exports**.

### 3.2. Enseignant

L’enseignant dispose de droits limités à son périmètre :
- consultation des stages dont il est **professeur de suivi** ou de **visite** ;
- mise à jour des **statuts de documents** (attestation, bilan, etc.) pour ces stages ;
- accès à une vue filtrée de **« Suivi & visites »** et à un tableau de bord adapté.

---

## 4. Navigation générale

Après connexion, vous accédez au menu latéral de l’application :

- **Accueil** : tableau de bord avec indicateurs et graphiques.
- **Étudiants** : liste et gestion des étudiants.
- **Entreprises** : liste et gestion des entreprises partenaires.
- **Stages** : liste et gestion des stages.
- **Suivi & visites** : vue de pilotage des stages et visites.
- **Exports** : export des données (CSV / Excel / PDF selon configuration).

En haut à droite, votre rôle (Administrateur / Enseignant) et un lien de **déconnexion** sont affichés.

---

## 5. Module Étudiants

> Accessible principalement aux administrateurs.

### 5.1. Consulter la liste

1. Cliquez sur **« Étudiants »** dans le menu.
2. La liste des étudiants s’affiche avec les principales informations (nom, prénom, filière, promotion…).
3. Vous pouvez utiliser la barre de recherche (si présente) pour filtrer par nom ou par promotion.

### 5.2. Ajouter un étudiant

1. Cliquez sur le bouton **« Ajouter un étudiant »**.
2. Remplissez les champs obligatoires :
   - Nom, Prénom,
   - Filière (SLAM / SISR),
   - Promotion,
   - Coordonnées (e‑mail, téléphone, si souhaité).
3. Validez le formulaire.
4. Un message de confirmation apparaît et l’étudiant est ajouté à la liste.

### 5.3. Modifier ou archiver un étudiant

1. Dans la liste, cliquez sur l’icône **« crayon »** ou le bouton **« Modifier »** de la ligne souhaitée.
2. Mettez à jour les informations.
3. Enregistrez.

Pour archiver un étudiant (ne plus le proposer pour de nouveaux stages mais garder l’historique) :
- cochez la case **« Archivé »** (ou un bouton spécifique), puis enregistrez.

---

## 6. Module Entreprises

> Accessible principalement aux administrateurs.

### 6.1. Consulter la liste

1. Cliquez sur **« Entreprises »** dans le menu.
2. La liste affiche le nom, l’adresse, la ville, le contact, l’e‑mail, etc.
3. Des filtres peuvent être disponibles (par ville ou secteur d’activité).

### 6.2. Ajouter une entreprise

1. Cliquez sur **« Ajouter une entreprise »**.
2. Renseignez au minimum :
   - Nom de l’entreprise,
   - Adresse, Code postal, Ville,
   - Coordonnées de contact (e‑mail, téléphone),
   - Nom du tuteur (facultatif).
3. Validez pour enregistrer.

### 6.3. Modifier une entreprise

1. Cliquez sur l’icône **« Modifier »** sur la ligne correspondante.
2. Adaptez les informations.
3. Enregistrez.

---

## 7. Module Stages

> Accessible principalement aux administrateurs.

### 7.1. Consulter la liste des stages

1. Cliquez sur **« Stages »**.
2. La liste affiche, pour chaque stage :
   - Étudiant,
   - Entreprise,
   - Dates de début et de fin,
   - Durée,
   - Professeur de suivi, Professeur de visite (si affectés),
   - Statut d’attestation (ou autres statuts).

### 7.2. Créer un nouveau stage

1. Cliquez sur **« Ajouter un stage »**.
2. Sélectionnez :
   - l’**Étudiant** concerné,
   - l’**Entreprise** d’accueil.
3. Renseignez :
   - la **date de début** et la **date de fin**, 
   - éventuellement une remarque ou description.
4. Validez le formulaire.

### 7.3. Modifier un stage

1. Dans la liste, cliquez sur l’icône **« crayon »** de la ligne du stage.
2. Modifiez les dates, l’entreprise, les remarques ou les affectations (voir section suivante).
3. Enregistrez.

---

## 8. Affectation des professeurs (suivi / visite)

> Fonction accessible aux administrateurs (UC-06).

1. Ouvrez la **fiche d’un stage** (via la liste Stages ou la vue Suivi & visites).
2. Repérez la section **« Professeur de suivi »** et **« Professeur de visite »**.
3. Choisissez les professeurs dans les listes déroulantes (seuls les utilisateurs de rôle enseignant sont proposés).
4. Enregistrez.

Une entrée est automatiquement ajoutée dans l’**historique** pour garder la trace des affectations.

---

## 9. Mise à jour des statuts (documents / jalons)

> Fonction principalement utilisée par les enseignants (UC-07), accessible aussi aux administrateurs.

1. Ouvrez la **fiche du stage** concerné (depuis Stages ou Suivi & visites).
2. Accédez à l’onglet ou la section **« Statuts »**.
3. Pour chaque type de document (par exemple : Remerciement, Bilan, Jury, Attestation) :
   - choisissez le statut (ex. « Non remis », « En cours », « Reçu », « Validé ») dans la liste déroulante ;
   - si nécessaire, ajoutez un **commentaire**.
4. Cliquez sur **« Enregistrer »**.

Le système :
- met à jour les statuts du stage ;
- ajoute une entrée dans l’historique (date, utilisateur, type de modification).

---

## 10. Vue « Suivi & visites »

> Vue de pilotage des stages, accessible aux administrateurs et enseignants (UC-08).

### 10.1. Accès à la vue

1. Cliquez sur **« Suivi & visites »** dans le menu.
2. La vue affiche un tableau synthétique des stages.

- Pour un **Administrateur** : tous les stages sont visibles.
- Pour un **Enseignant** : seuls les stages dont il est prof de suivi ou de visite sont affichés.

### 10.2. Filtres et recherche

En haut du tableau, des filtres peuvent être disponibles (suivant la configuration) :
- Promotion / année,
- Filière (SLAM / SISR),
- Entreprise,
- Professeur de suivi ou de visite,
- Statut d’attestation ou d’autres documents.

Pour filtrer :
1. Sélectionnez les critères souhaités.
2. Cliquez sur **« Filtrer »** ou patientez si le filtrage est automatique.

### 10.3. Accès aux actions

Depuis la vue « Suivi & visites », vous pouvez généralement :
- ouvrir la **fiche détaillée** d’un stage ;
- accéder à l’**historique** des actions ;
- (pour l’Admin) lancer un **export** de la vue filtrée (selon intégration).

---

## 11. Tableau de bord (Accueil)

> Vue principale après connexion (UC-10).

1. Cliquez sur **« Accueil »** si vous n’êtes pas déjà sur le tableau de bord.
2. Vous y trouvez :
   - des **indicateurs** (widgets) avec des chiffres clés : nombre d’étudiants, stages en cours, visites à planifier, etc. ;
   - des **graphes** (barres, camemberts) montrant par exemple la répartition des stages par filière ou par entreprise ;
   - la liste des **prochaines visites** à réaliser.

Les données affichées peuvent être adaptées à votre rôle (vue globale pour l’Admin, vue restreinte pour l’enseignant).

---

## 12. Module Exports (CSV / Excel / PDF)

> Principalement utilisé par l’administrateur et le secrétariat.

1. Cliquez sur **« Exports »** dans le menu.
2. Trois cartes (ou plus selon configuration) sont proposées, par exemple :
   - **Liste des étudiants** : export CSV ou PDF de tous les étudiants, avec leurs informations principales.
   - **Liste des entreprises** : export CSV des entreprises partenaires (coordonnées, contact, ville…).
   - **Rapport des stages** : export CSV/Excel des stages (souvent basé sur la vue Suivi & visites).

### 12.1. Export de la liste des étudiants

1. Sur la carte **« Liste des étudiants »**, cliquez sur le bouton **« Exporter »**.
2. Le navigateur télécharge un fichier (CSV ou PDF selon le bouton).
3. Ouvrez le fichier dans Excel, LibreOffice ou un lecteur PDF.

### 12.2. Export de la liste des entreprises (CSV)

1. Sur la carte **« Liste des entreprises »**, cliquez sur **« Exporter (CSV) »**.
2. Le fichier CSV contient les informations nécessaires (nom, adresse, ville, contact, e‑mail, téléphone…).
3. Vous pouvez trier ou filtrer ces données directement dans Excel.

### 12.3. Export du rapport des stages (CSV/Excel)

1. Facultatif : allez d’abord dans **« Suivi & visites »** et appliquez les filtres souhaités (promotion, filière, entreprise, statut…).
2. Rejoignez le module **« Exports »**.
3. Sur la carte **« Rapport des stages »**, cliquez sur **« Exporter »**.
4. Le fichier téléchargé reprend la liste des stages, idéalement en tenant compte des filtres actifs.

Le format CSV généré est compatible avec Excel (séparateur `;` et encodage UTF‑8 avec BOM).

---

## 13. Historique et traçabilité

Chaque fois qu’une action importante est réalisée (ex. modification d’affectation, mise à jour de statut), une entrée est ajoutée dans l’**historique** du stage. 

Selon l’interface :
- un bouton **« Historique »** peut être disponible sur la fiche stage ou dans la vue Suivi & visites ;
- un clic affiche la liste datée des actions (qui, quoi, quand).

Cela permet de suivre précisément l’évolution du dossier de stage.

---

## 14. Conseils d’utilisation / bonnes pratiques

- **Mise à jour régulière** : pensez à mettre à jour les statuts (attestations, bilans, etc.) dès qu’un document est reçu.
- **Filtres** : utilisez les filtres de la vue « Suivi & visites » pour préparer vos visites ou vos relances.
- **Exports** : privilégiez l’export CSV/Excel pour transmettre des listes au secrétariat ou à la direction.
- **Sécurité** : ne partagez pas vos identifiants. Utilisez la déconnexion lorsque vous quittez l’application.

---

## 15. Support et contact

En cas de problème technique ou de question sur l’utilisation de l’application :
- contactez l’**administrateur** de l’outil ;
- ou l’enseignant référent du projet BTS SIO.

Merci d’utiliser l’application « Suivi des stages » pour faciliter le suivi des périodes en entreprise des étudiants.
