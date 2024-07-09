<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709122440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Event<->Organization] Add Many Event To Many Organization.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_organization (
          event_id INTEGER NOT NULL,
          organization_id INTEGER NOT NULL,
          PRIMARY KEY(event_id, organization_id),
          CONSTRAINT FK_2CFD698F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
          CONSTRAINT FK_2CFD698F32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('CREATE INDEX IDX_2CFD698F71F7E88B ON event_organization (event_id)');
        $this->addSql('CREATE INDEX IDX_2CFD698F32C8A3DE ON event_organization (organization_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event_organization');
    }
}
