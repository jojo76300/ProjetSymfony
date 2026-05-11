<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260504094719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE statut_dossier');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY `FK_AFFECT_ENSEIGNANT`');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY `FK_AFFECT_STAGE`');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D32298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE affectation RENAME INDEX idx_affect_stage TO IDX_F4DD61D32298D193');
        $this->addSql('ALTER TABLE affectation RENAME INDEX idx_affect_enseignant TO IDX_F4DD61D3E455FCC0');
        $this->addSql('ALTER TABLE avoir ADD CONSTRAINT FK_659B1A43FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avoir ADD CONSTRAINT FK_659B1A43D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY `FK_ETUDIANT_PROMOTION`');
        $this->addSql('ALTER TABLE etudiant DROP ann_promotion, CHANGE promotion_id promotion_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE etudiant RENAME INDEX idx_etudiant_promotion TO IDX_717E22E3139DF194');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY `FK_HISTORIQUE_AUTEUR`');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY `FK_HISTORIQUE_STAGE`');
        $this->addSql('ALTER TABLE historique ADD action VARCHAR(255) NOT NULL, DROP type_changement, DROP champ_modifie, DROP ancienne_valeur, DROP nouvelle_valeur, CHANGE date_heure date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE historique RENAME INDEX idx_historique_auteur TO IDX_EDBFD5EC60BB6FE6');
        $this->addSql('ALTER TABLE historique RENAME INDEX idx_historique_stage TO IDX_EDBFD5EC2298D193');
        $this->addSql('DROP INDEX UK_PROMOTION_CLASSE_SESSION ON promotion');
        $this->addSql('ALTER TABLE role CHANGE libelle_symfony libelle_symfony VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY `FK_STAGE_PROF_SUIVI`');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY `FK_STAGE_PROF_VISITE`');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY `FK_STAGE_STATUT_DOSSIER`');
        $this->addSql('DROP INDEX IDX_STAGE_STATUT_DOSSIER ON stage');
        $this->addSql('ALTER TABLE stage DROP statut_dossier_id');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369D5073BAA FOREIGN KEY (prof_suivi_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93696C08B97D FOREIGN KEY (prof_visite_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stage RENAME INDEX idx_stage_prof_suivi TO IDX_C27C9369D5073BAA');
        $this->addSql('ALTER TABLE stage RENAME INDEX idx_stage_prof_visite TO IDX_C27C93696C08B97D');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statut_dossier (id INT AUTO_INCREMENT NOT NULL, remerciement VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, bilan_suivi VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, jury VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, attestation VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, commentaire_global TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D32298D193');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3E455FCC0');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT `FK_AFFECT_ENSEIGNANT` FOREIGN KEY (enseignant_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT `FK_AFFECT_STAGE` FOREIGN KEY (stage_id) REFERENCES stage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE affectation RENAME INDEX idx_f4dd61d3e455fcc0 TO IDX_AFFECT_ENSEIGNANT');
        $this->addSql('ALTER TABLE affectation RENAME INDEX idx_f4dd61d32298d193 TO IDX_AFFECT_STAGE');
        $this->addSql('ALTER TABLE avoir DROP FOREIGN KEY FK_659B1A43FB88E14F');
        $this->addSql('ALTER TABLE avoir DROP FOREIGN KEY FK_659B1A43D60322AC');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3139DF194');
        $this->addSql('ALTER TABLE etudiant ADD ann_promotion VARCHAR(30) NOT NULL, CHANGE promotion_id promotion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT `FK_ETUDIANT_PROMOTION` FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE etudiant RENAME INDEX idx_717e22e3139df194 TO IDX_ETUDIANT_PROMOTION');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC60BB6FE6');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC2298D193');
        $this->addSql('ALTER TABLE historique ADD type_changement VARCHAR(50) NOT NULL, ADD champ_modifie VARCHAR(100) NOT NULL, ADD ancienne_valeur TEXT DEFAULT NULL, ADD nouvelle_valeur TEXT DEFAULT NULL, DROP action, CHANGE date_creation date_heure DATETIME NOT NULL');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT `FK_HISTORIQUE_AUTEUR` FOREIGN KEY (auteur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT `FK_HISTORIQUE_STAGE` FOREIGN KEY (stage_id) REFERENCES stage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historique RENAME INDEX idx_edbfd5ec60bb6fe6 TO IDX_HISTORIQUE_AUTEUR');
        $this->addSql('ALTER TABLE historique RENAME INDEX idx_edbfd5ec2298d193 TO IDX_HISTORIQUE_STAGE');
        $this->addSql('CREATE UNIQUE INDEX UK_PROMOTION_CLASSE_SESSION ON promotion (classe, session)');
        $this->addSql('ALTER TABLE role CHANGE libelle_symfony libelle_symfony VARCHAR(50) DEFAULT \'ROLE_USER\' NOT NULL');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369D5073BAA');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93696C08B97D');
        $this->addSql('ALTER TABLE stage ADD statut_dossier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT `FK_STAGE_PROF_SUIVI` FOREIGN KEY (prof_suivi_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT `FK_STAGE_PROF_VISITE` FOREIGN KEY (prof_visite_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT `FK_STAGE_STATUT_DOSSIER` FOREIGN KEY (statut_dossier_id) REFERENCES statut_dossier (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_STAGE_STATUT_DOSSIER ON stage (statut_dossier_id)');
        $this->addSql('ALTER TABLE stage RENAME INDEX idx_c27c9369d5073baa TO IDX_STAGE_PROF_SUIVI');
        $this->addSql('ALTER TABLE stage RENAME INDEX idx_c27c93696c08b97d TO IDX_STAGE_PROF_VISITE');
    }
}
