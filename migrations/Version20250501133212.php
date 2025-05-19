<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501133212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items DROP FOREIGN KEY FK_38967F8C22532272
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items DROP FOREIGN KEY FK_38967F8CDE18E50B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_38967F8C22532272 ON stock_request_items
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_38967F8CDE18E50B ON stock_request_items
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items ADD stock_request_id INT NOT NULL, ADD product_id INT NOT NULL, DROP request_id_id, DROP product_id_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items ADD CONSTRAINT FK_38967F8CEC374F09 FOREIGN KEY (stock_request_id) REFERENCES stock_request (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items ADD CONSTRAINT FK_38967F8C4584665A FOREIGN KEY (product_id) REFERENCES products (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_38967F8CEC374F09 ON stock_request_items (stock_request_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_38967F8C4584665A ON stock_request_items (product_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items DROP FOREIGN KEY FK_38967F8CEC374F09
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items DROP FOREIGN KEY FK_38967F8C4584665A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_38967F8CEC374F09 ON stock_request_items
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_38967F8C4584665A ON stock_request_items
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items ADD request_id_id INT NOT NULL, ADD product_id_id INT NOT NULL, DROP stock_request_id, DROP product_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items ADD CONSTRAINT FK_38967F8C22532272 FOREIGN KEY (request_id_id) REFERENCES stock_request (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_items ADD CONSTRAINT FK_38967F8CDE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_38967F8C22532272 ON stock_request_items (request_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_38967F8CDE18E50B ON stock_request_items (product_id_id)
        SQL);
    }
}
