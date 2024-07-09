<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709120326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[INIT] Event, Organization, Project & Volunteer.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
        $this->addSql('CREATE TABLE organization (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          name VARCHAR(255) NOT NULL,
          presentation CLOB NOT NULL,
          created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          )');
        $this->addSql('CREATE TABLE project (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          name VARCHAR(255) NOT NULL,
          summary CLOB NOT NULL,
          created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
          )');
        $this->addSql('CREATE TABLE volunteer (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          )');
        $this->addSql('CREATE TABLE messenger_messages (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          body CLOB NOT NULL,
          headers CLOB NOT NULL,
          queue_name VARCHAR(190) NOT NULL,
          created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
          ,
          delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
          )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE volunteer');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
