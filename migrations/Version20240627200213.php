<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627200213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE chat_message_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE chat_message_entity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chat_message_entity (id INT NOT NULL, status BOOLEAN NOT NULL, sent BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE chat_message');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE chat_message_entity_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE chat_message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chat_message (id INT NOT NULL, status BOOLEAN NOT NULL, sent BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE chat_message_entity');
    }
}
