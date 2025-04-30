<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430095236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_request (id INT AUTO_INCREMENT NOT NULL, from_site_id INT NOT NULL, to_site_id INT NOT NULL, requested_by_id INT NOT NULL, approved_by_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_22319F3C70E3F5E9 (from_site_id), INDEX IDX_22319F3C78252BB3 (to_site_id), INDEX IDX_22319F3C4DA1E751 (requested_by_id), INDEX IDX_22319F3C2D234F6A (approved_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD CONSTRAINT FK_22319F3C70E3F5E9 FOREIGN KEY (from_site_id) REFERENCES sites (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD CONSTRAINT FK_22319F3C78252BB3 FOREIGN KEY (to_site_id) REFERENCES sites (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD CONSTRAINT FK_22319F3C4DA1E751 FOREIGN KEY (requested_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD CONSTRAINT FK_22319F3C2D234F6A FOREIGN KEY (approved_by_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request DROP FOREIGN KEY FK_22319F3C70E3F5E9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request DROP FOREIGN KEY FK_22319F3C78252BB3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request DROP FOREIGN KEY FK_22319F3C4DA1E751
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request DROP FOREIGN KEY FK_22319F3C2D234F6A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_request
        SQL);
    }
}
