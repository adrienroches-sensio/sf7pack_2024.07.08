<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709122838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Relations] Add missing relations.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_organization (
          project_id INTEGER NOT NULL,
          organization_id INTEGER NOT NULL,
          PRIMARY KEY(project_id, organization_id),
          CONSTRAINT FK_EB49871F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
          CONSTRAINT FK_EB49871F32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('CREATE INDEX IDX_EB49871F166D1F9C ON project_organization (project_id)');
        $this->addSql('CREATE INDEX IDX_EB49871F32C8A3DE ON project_organization (organization_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS
        SELECT
          id,
          name,
          description,
          ACCESSIBLE,
          prerequisites,
          start_at,
          end_at
        FROM
          event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          project_id INTEGER NOT NULL,
          name VARCHAR(255) NOT NULL,
          description CLOB NOT NULL,
          ACCESSIBLE BOOLEAN NOT NULL,
          prerequisites CLOB DEFAULT NULL,
          start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          CONSTRAINT FK_3BAE0AA7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('INSERT INTO event (
          id, name, description, ACCESSIBLE,
          prerequisites, start_at, end_at
        )
        SELECT
          id,
          name,
          description,
          ACCESSIBLE,
          prerequisites,
          start_at,
          end_at
        FROM
          __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7166D1F9C ON event (project_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__volunteer AS
        SELECT
          id,
          event_id,
          start_at,
          end_at
        FROM
          volunteer');
        $this->addSql('DROP TABLE volunteer');
        $this->addSql('CREATE TABLE volunteer (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          event_id INTEGER NOT NULL,
          project_id INTEGER NOT NULL,
          start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          CONSTRAINT FK_5140DEDB71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE,
          CONSTRAINT FK_5140DEDB166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('INSERT INTO volunteer (id, event_id, start_at, end_at)
        SELECT
          id,
          event_id,
          start_at,
          end_at
        FROM
          __temp__volunteer');
        $this->addSql('DROP TABLE __temp__volunteer');
        $this->addSql('CREATE INDEX IDX_5140DEDB71F7E88B ON volunteer (event_id)');
        $this->addSql('CREATE INDEX IDX_5140DEDB166D1F9C ON volunteer (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_organization');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS
        SELECT
          id,
          name,
          description,
          ACCESSIBLE,
          prerequisites,
          start_at,
          end_at
        FROM
          event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          name VARCHAR(255) NOT NULL,
          description CLOB NOT NULL,
          ACCESSIBLE BOOLEAN NOT NULL,
          prerequisites CLOB DEFAULT NULL,
          start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          )');
        $this->addSql('INSERT INTO event (
          id, name, description, ACCESSIBLE,
          prerequisites, start_at, end_at
        )
        SELECT
          id,
          name,
          description,
          ACCESSIBLE,
          prerequisites,
          start_at,
          end_at
        FROM
          __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE TEMPORARY TABLE __temp__volunteer AS
        SELECT
          id,
          event_id,
          start_at,
          end_at
        FROM
          volunteer');
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
        $this->addSql('INSERT INTO volunteer (id, event_id, start_at, end_at)
        SELECT
          id,
          event_id,
          start_at,
          end_at
        FROM
          __temp__volunteer');
        $this->addSql('DROP TABLE __temp__volunteer');
        $this->addSql('CREATE INDEX IDX_5140DEDB71F7E88B ON volunteer (event_id)');
    }
}
