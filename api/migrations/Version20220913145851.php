<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913145851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE greeting_id_seq CASCADE');
        $this->addSql('DROP TABLE greeting');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526c30122c15');
        $this->addSql('DROP INDEX idx_9474526c30122c15');
        $this->addSql('ALTER TABLE comment RENAME COLUMN joke_id TO answer_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CAA334807 FOREIGN KEY (answer_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9474526CAA334807 ON comment (answer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE greeting (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CAA334807');
        $this->addSql('DROP INDEX IDX_9474526CAA334807');
        $this->addSql('ALTER TABLE comment RENAME COLUMN answer_id TO joke_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526c30122c15 FOREIGN KEY (joke_id) REFERENCES joke (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9474526c30122c15 ON comment (joke_id)');
    }
}
