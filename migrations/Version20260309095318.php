<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260309095318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avoir (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_659B1A43FB88E14F (utilisateur_id), INDEX IDX_659B1A43D60322AC (role_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(38) NOT NULL, prenom VARCHAR(38) NOT NULL, filiere VARCHAR(100) NOT NULL, ann_promotion VARCHAR(30) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, mdp VARCHAR(255) NOT NULL, status TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE avoir ADD CONSTRAINT FK_659B1A43FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avoir ADD CONSTRAINT FK_659B1A43D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avoir DROP FOREIGN KEY FK_659B1A43FB88E14F');
        $this->addSql('ALTER TABLE avoir DROP FOREIGN KEY FK_659B1A43D60322AC');
        $this->addSql('DROP TABLE avoir');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE utilisateur');
    }
}
