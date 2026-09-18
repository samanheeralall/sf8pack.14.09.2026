<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260918125149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, loan_date DATETIME NOT NULL, due_date DATETIME NOT NULL, return_date DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, user_id INTEGER DEFAULT NULL, book_id INTEGER DEFAULT NULL, CONSTRAINT FK_C5D30D03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C5D30D0316A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C5D30D03A76ED395 ON loan (user_id)');
        $this->addSql('CREATE INDEX IDX_C5D30D0316A2B381 ON loan (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE loan');
    }
}
