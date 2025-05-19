<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509111128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE categories_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_2541314bd5b83c0fa72d347646661e02_idx (type), INDEX object_id_2541314bd5b83c0fa72d347646661e02_idx (object_id), INDEX discriminator_2541314bd5b83c0fa72d347646661e02_idx (discriminator), INDEX transaction_hash_2541314bd5b83c0fa72d347646661e02_idx (transaction_hash), INDEX blame_id_2541314bd5b83c0fa72d347646661e02_idx (blame_id), INDEX created_at_2541314bd5b83c0fa72d347646661e02_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE products_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_bfbae432b02e249bfbe7d8f1c7d76d4a_idx (type), INDEX object_id_bfbae432b02e249bfbe7d8f1c7d76d4a_idx (object_id), INDEX discriminator_bfbae432b02e249bfbe7d8f1c7d76d4a_idx (discriminator), INDEX transaction_hash_bfbae432b02e249bfbe7d8f1c7d76d4a_idx (transaction_hash), INDEX blame_id_bfbae432b02e249bfbe7d8f1c7d76d4a_idx (blame_id), INDEX created_at_bfbae432b02e249bfbe7d8f1c7d76d4a_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sites_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_d7f0566263d5db740f0fe87c5784b700_idx (type), INDEX object_id_d7f0566263d5db740f0fe87c5784b700_idx (object_id), INDEX discriminator_d7f0566263d5db740f0fe87c5784b700_idx (discriminator), INDEX transaction_hash_d7f0566263d5db740f0fe87c5784b700_idx (transaction_hash), INDEX blame_id_d7f0566263d5db740f0fe87c5784b700_idx (blame_id), INDEX created_at_d7f0566263d5db740f0fe87c5784b700_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_request_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_73809603de7578f26fc82b37f446102e_idx (type), INDEX object_id_73809603de7578f26fc82b37f446102e_idx (object_id), INDEX discriminator_73809603de7578f26fc82b37f446102e_idx (discriminator), INDEX transaction_hash_73809603de7578f26fc82b37f446102e_idx (transaction_hash), INDEX blame_id_73809603de7578f26fc82b37f446102e_idx (blame_id), INDEX created_at_73809603de7578f26fc82b37f446102e_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_request_items_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_a91530aec73dea041c6971bba13a0de2_idx (type), INDEX object_id_a91530aec73dea041c6971bba13a0de2_idx (object_id), INDEX discriminator_a91530aec73dea041c6971bba13a0de2_idx (discriminator), INDEX transaction_hash_a91530aec73dea041c6971bba13a0de2_idx (transaction_hash), INDEX blame_id_a91530aec73dea041c6971bba13a0de2_idx (blame_id), INDEX created_at_a91530aec73dea041c6971bba13a0de2_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_e06395edc291d0719bee26fd39a32e8a_idx (type), INDEX object_id_e06395edc291d0719bee26fd39a32e8a_idx (object_id), INDEX discriminator_e06395edc291d0719bee26fd39a32e8a_idx (discriminator), INDEX transaction_hash_e06395edc291d0719bee26fd39a32e8a_idx (transaction_hash), INDEX blame_id_e06395edc291d0719bee26fd39a32e8a_idx (blame_id), INDEX created_at_e06395edc291d0719bee26fd39a32e8a_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD remarks LONGTEXT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE categories_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE products_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sites_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_request_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_request_items_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_audit
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request DROP remarks
        SQL);
    }
}
