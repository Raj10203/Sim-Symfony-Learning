<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603083051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE active_inventory (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, site_id INT NOT NULL, last_stock_movement_id INT DEFAULT NULL, serial_no VARCHAR(50) NOT NULL, received_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', remarks LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A7BB09024584665A (product_id), INDEX IDX_A7BB0902F6BD1646 (site_id), INDEX IDX_A7BB090254CA4B4B (last_stock_movement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE active_inventory_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_bb6ee48c4fd3a823665c33467b5105ae_idx (type), INDEX object_id_bb6ee48c4fd3a823665c33467b5105ae_idx (object_id), INDEX discriminator_bb6ee48c4fd3a823665c33467b5105ae_idx (discriminator), INDEX transaction_hash_bb6ee48c4fd3a823665c33467b5105ae_idx (transaction_hash), INDEX blame_id_bb6ee48c4fd3a823665c33467b5105ae_idx (blame_id), INDEX created_at_bb6ee48c4fd3a823665c33467b5105ae_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE inventory_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_627e0edfda300995871d8a701fd679ad_idx (type), INDEX object_id_627e0edfda300995871d8a701fd679ad_idx (object_id), INDEX discriminator_627e0edfda300995871d8a701fd679ad_idx (discriminator), INDEX transaction_hash_627e0edfda300995871d8a701fd679ad_idx (transaction_hash), INDEX blame_id_627e0edfda300995871d8a701fd679ad_idx (blame_id), INDEX created_at_627e0edfda300995871d8a701fd679ad_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE retired_inventory (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, site_id INT NOT NULL, retired_by_id INT NOT NULL, retired_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', status VARCHAR(20) NOT NULL, retirement_reason LONGTEXT DEFAULT NULL, serial_no VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1BB840E4584665A (product_id), INDEX IDX_1BB840EF6BD1646 (site_id), INDEX IDX_1BB840EAE9EDADF (retired_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE retired_inventory_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_f51976e6c4e62fcd52ad9ee0dd6dc00d_idx (type), INDEX object_id_f51976e6c4e62fcd52ad9ee0dd6dc00d_idx (object_id), INDEX discriminator_f51976e6c4e62fcd52ad9ee0dd6dc00d_idx (discriminator), INDEX transaction_hash_f51976e6c4e62fcd52ad9ee0dd6dc00d_idx (transaction_hash), INDEX blame_id_f51976e6c4e62fcd52ad9ee0dd6dc00d_idx (blame_id), INDEX created_at_f51976e6c4e62fcd52ad9ee0dd6dc00d_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_movement (id INT AUTO_INCREMENT NOT NULL, stock_request_id INT NOT NULL, status VARCHAR(50) NOT NULL, remarks LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BB1BC1B5EC374F09 (stock_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_movement_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_0264a47b0910c7ac6f93d865c4f38149_idx (type), INDEX object_id_0264a47b0910c7ac6f93d865c4f38149_idx (object_id), INDEX discriminator_0264a47b0910c7ac6f93d865c4f38149_idx (discriminator), INDEX transaction_hash_0264a47b0910c7ac6f93d865c4f38149_idx (transaction_hash), INDEX blame_id_0264a47b0910c7ac6f93d865c4f38149_idx (blame_id), INDEX created_at_0264a47b0910c7ac6f93d865c4f38149_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_movement_item (id INT AUTO_INCREMENT NOT NULL, stock_movement_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, remarks LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_43AA60E0FD50D693 (stock_movement_id), INDEX IDX_43AA60E04584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_movement_item_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_94034c3ffe7b00c1b740dfe441e8e83d_idx (type), INDEX object_id_94034c3ffe7b00c1b740dfe441e8e83d_idx (object_id), INDEX discriminator_94034c3ffe7b00c1b740dfe441e8e83d_idx (discriminator), INDEX transaction_hash_94034c3ffe7b00c1b740dfe441e8e83d_idx (transaction_hash), INDEX blame_id_94034c3ffe7b00c1b740dfe441e8e83d_idx (blame_id), INDEX created_at_94034c3ffe7b00c1b740dfe441e8e83d_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE active_inventory ADD CONSTRAINT FK_A7BB09024584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE active_inventory ADD CONSTRAINT FK_A7BB0902F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE active_inventory ADD CONSTRAINT FK_A7BB090254CA4B4B FOREIGN KEY (last_stock_movement_id) REFERENCES stock_movement (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE retired_inventory ADD CONSTRAINT FK_1BB840E4584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE retired_inventory ADD CONSTRAINT FK_1BB840EF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE retired_inventory ADD CONSTRAINT FK_1BB840EAE9EDADF FOREIGN KEY (retired_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement ADD CONSTRAINT FK_BB1BC1B5EC374F09 FOREIGN KEY (stock_request_id) REFERENCES stock_request (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement_item ADD CONSTRAINT FK_43AA60E0FD50D693 FOREIGN KEY (stock_movement_id) REFERENCES stock_movement (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement_item ADD CONSTRAINT FK_43AA60E04584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE active_inventory DROP FOREIGN KEY FK_A7BB09024584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE active_inventory DROP FOREIGN KEY FK_A7BB0902F6BD1646
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE active_inventory DROP FOREIGN KEY FK_A7BB090254CA4B4B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE retired_inventory DROP FOREIGN KEY FK_1BB840E4584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE retired_inventory DROP FOREIGN KEY FK_1BB840EF6BD1646
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE retired_inventory DROP FOREIGN KEY FK_1BB840EAE9EDADF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement DROP FOREIGN KEY FK_BB1BC1B5EC374F09
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement_item DROP FOREIGN KEY FK_43AA60E0FD50D693
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_movement_item DROP FOREIGN KEY FK_43AA60E04584665A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE active_inventory
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE active_inventory_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE inventory_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE retired_inventory
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE retired_inventory_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_movement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_movement_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_movement_item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_movement_item_audit
        SQL);
    }
}
