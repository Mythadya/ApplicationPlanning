<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603090544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
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
}
