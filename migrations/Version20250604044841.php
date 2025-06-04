<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250604044841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_A7BB090277119FDA ON active_inventory (serial_no)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_product_site ON active_inventory (product_id, site_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_A7BB090277119FDA ON active_inventory
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_product_site ON active_inventory
        SQL);
    }
}
