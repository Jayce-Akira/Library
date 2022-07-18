<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718145027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des relations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_type (book_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_95431C2116A2B381 (book_id), INDEX IDX_95431C21C54C8C93 (type_id), PRIMARY KEY(book_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_loan_book (book_loan_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_8E6CF035D53AE19 (book_loan_id), INDEX IDX_8E6CF0316A2B381 (book_id), PRIMARY KEY(book_loan_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C2116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C21C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_loan_book ADD CONSTRAINT FK_8E6CF035D53AE19 FOREIGN KEY (book_loan_id) REFERENCES book_loan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_loan_book ADD CONSTRAINT FK_8E6CF0316A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_loan ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_loan ADD CONSTRAINT FK_DC4E460BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DC4E460BA76ED395 ON book_loan (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book_type');
        $this->addSql('DROP TABLE book_loan_book');
        $this->addSql('ALTER TABLE book_loan DROP FOREIGN KEY FK_DC4E460BA76ED395');
        $this->addSql('DROP INDEX IDX_DC4E460BA76ED395 ON book_loan');
        $this->addSql('ALTER TABLE book_loan DROP user_id');
    }
}
