<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250528110357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE formation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, formateur_id VARCHAR(36) NOT NULL, actif BOOLEAN NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, nom VARCHAR(150) NOT NULL, numero VARCHAR(100) DEFAULT NULL, etat VARCHAR(30) NOT NULL, titre_pro VARCHAR(150) DEFAULT NULL, niveau VARCHAR(100) DEFAULT NULL, nb_stagiaires_prevision VARCHAR(50) DEFAULT NULL, groupe_rattachement VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_404021BF155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_404021BF155D8F51 ON formation (formateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE interruption (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, formation_id INTEGER NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, motif VARCHAR(150) NOT NULL, created_at DATETIME NOT NULL, CONSTRAINT FK_F9511BC05200282E FOREIGN KEY (formation_id) REFERENCES formation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F9511BC05200282E ON interruption (formation_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE periode_entreprise (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, formation_id INTEGER NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, created_at DATETIME NOT NULL, CONSTRAINT FK_E4950F8A5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E4950F8A5200282E ON periode_entreprise (formation_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__formateur AS SELECT id, nom, prenom, email FROM formateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE formateur
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE formateur (id VARCHAR(36) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) DEFAULT NULL, email VARCHAR(150) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO formateur (id, nom, prenom, email) SELECT id, nom, prenom, email FROM __temp__formateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__formateur
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_ED767E4FE7927C74 ON formateur (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__invitation AS SELECT id, email, token, date_envoi, is_used FROM invitation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE invitation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE invitation (id VARCHAR(36) NOT NULL, email VARCHAR(150) NOT NULL, token VARCHAR(255) NOT NULL, date_envoi DATE NOT NULL, is_used BOOLEAN NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO invitation (id, email, token, date_envoi, is_used) SELECT id, email, token, date_envoi, is_used FROM __temp__invitation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__invitation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F11D61A25F37A13B ON invitation (token)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F11D61A2E7927C74 ON invitation (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__jour_ferie AS SELECT id, date, nom FROM jour_ferie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE jour_ferie
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE jour_ferie (id VARCHAR(36) NOT NULL, date DATE NOT NULL, nom VARCHAR(150) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO jour_ferie (id, date, nom) SELECT id, date, nom FROM __temp__jour_ferie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__jour_ferie
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE formation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE interruption
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE periode_entreprise
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__formateur AS SELECT id, nom, prenom, email FROM formateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE formateur
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE formateur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(1500) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO formateur (id, nom, prenom, email) SELECT id, nom, prenom, email FROM __temp__formateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__formateur
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__invitation AS SELECT id, email, token, date_envoi, is_used FROM invitation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE invitation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE invitation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(150) NOT NULL, token VARCHAR(255) NOT NULL, date_envoi DATE NOT NULL, is_used BOOLEAN NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO invitation (id, email, token, date_envoi, is_used) SELECT id, email, token, date_envoi, is_used FROM __temp__invitation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__invitation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F11D61A2E7927C74 ON invitation (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F11D61A25F37A13B ON invitation (token)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__jour_ferie AS SELECT id, date, nom FROM jour_ferie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE jour_ferie
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE jour_ferie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL, nom VARCHAR(150) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO jour_ferie (id, date, nom) SELECT id, date, nom FROM __temp__jour_ferie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__jour_ferie
        SQL);
    }
}
