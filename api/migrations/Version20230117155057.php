<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117155057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joke_category DROP CONSTRAINT fk_eba09fc430122c15');
        $this->addSql('ALTER TABLE rate DROP CONSTRAINT fk_dfec3f3930122c15');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526c30122c15');
        $this->addSql('ALTER TABLE joke_category DROP CONSTRAINT fk_eba09fc412469de2');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526caa334807');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE joke_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rate_id_seq CASCADE');
        $this->addSql('DROP TABLE joke');
        $this->addSql('DROP TABLE joke_category');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE comment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE joke_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE joke (id INT NOT NULL, text TEXT NOT NULL, answer TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE joke_category (joke_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(joke_id, category_id))');
        $this->addSql('CREATE INDEX idx_eba09fc412469de2 ON joke_category (category_id)');
        $this->addSql('CREATE INDEX idx_eba09fc430122c15 ON joke_category (joke_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE rate (id INT NOT NULL, joke_id INT DEFAULT NULL, star INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_dfec3f3930122c15 ON rate (joke_id)');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, answer_id INT DEFAULT NULL, joke_id INT DEFAULT NULL, message TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9474526caa334807 ON comment (answer_id)');
        $this->addSql('CREATE INDEX idx_9474526c30122c15 ON comment (joke_id)');
        $this->addSql('ALTER TABLE joke_category ADD CONSTRAINT fk_eba09fc430122c15 FOREIGN KEY (joke_id) REFERENCES joke (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE joke_category ADD CONSTRAINT fk_eba09fc412469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT fk_dfec3f3930122c15 FOREIGN KEY (joke_id) REFERENCES joke (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526caa334807 FOREIGN KEY (answer_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526c30122c15 FOREIGN KEY (joke_id) REFERENCES joke (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
