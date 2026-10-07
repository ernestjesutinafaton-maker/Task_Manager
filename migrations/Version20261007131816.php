<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261007131816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE to_do ADD COLUMN assigned_to VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__to_do AS SELECT id, title, content, status, date FROM to_do');
        $this->addSql('DROP TABLE to_do');
        $this->addSql('CREATE TABLE to_do (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, status INTEGER NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO to_do (id, title, content, status, date) SELECT id, title, content, status, date FROM __temp__to_do');
        $this->addSql('DROP TABLE __temp__to_do');
    }
}
