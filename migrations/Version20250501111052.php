<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501111052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_request_items (id INT AUTO_INCREMENT NOT NULL, request_id_id INT NOT NULL, product_id_id INT NOT NULL, quantity_requested INT NOT NULL, quantity_approved INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_38967F8C22532272 (request_id_id), INDEX IDX_38967F8CDE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL
        );
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items ADD CONSTRAINT FK_38967F8C22532272 FOREIGN KEY (request_id_id) REFERENCES
             stock_request (id) ON DELETE CASCADE 
        SQL
        );
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items ADD CONSTRAINT FK_38967F8CDE18E50B FOREIGN KEY (product_id_id) REFERENCES
             products (id) ON DELETE CASCADE 
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items DROP FOREIGN KEY FK_38967F8C22532272
        SQL
        );
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items DROP FOREIGN KEY FK_38967F8CDE18E50B
        SQL
        );
        $this->addSql(<<<'SQL'
            DROP TABLE stock_request_items
        SQL
        );
    }
}
