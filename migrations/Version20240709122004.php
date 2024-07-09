<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709122004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Event<->Volunteer] Add One Event To Many Volunteer.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__volunteer AS SELECT id, start_at, end_at FROM volunteer');
        $this->addSql('DROP TABLE volunteer');
        $this->addSql('CREATE TABLE volunteer (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          event_id INTEGER NOT NULL,
          start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          CONSTRAINT FK_5140DEDB71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('INSERT INTO volunteer (id, start_at, end_at)
        SELECT
          id,
          start_at,
          end_at
        FROM
          __temp__volunteer');
        $this->addSql('DROP TABLE __temp__volunteer');
        $this->addSql('CREATE INDEX IDX_5140DEDB71F7E88B ON volunteer (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__volunteer AS SELECT id, start_at, end_at FROM volunteer');
        $this->addSql('DROP TABLE volunteer');
        $this->addSql('CREATE TABLE volunteer (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          start_at DATETIME NOT NULL --(DC2Type:datetime_immutable),
          end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          )');
        $this->addSql('INSERT INTO volunteer (id, start_at, end_at)
        SELECT
          id,
          start_at,
          end_at
        FROM
          __temp__volunteer');
        $this->addSql('DROP TABLE __temp__volunteer');
    }
}
