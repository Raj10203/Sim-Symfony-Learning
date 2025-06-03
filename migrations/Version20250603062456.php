<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603062456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, site_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_B12D4A364584665A (product_id), INDEX IDX_B12D4A36F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A364584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product ADD unit  VARCHAR(20) NOT NULL AFTER description
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A364584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36F6BD1646
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE inventory
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP unit
        SQL);
    }
}
