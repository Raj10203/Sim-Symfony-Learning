<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603055457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_9d60be1ae31861a527fd590d589be976_idx (type), INDEX object_id_9d60be1ae31861a527fd590d589be976_idx (object_id), INDEX discriminator_9d60be1ae31861a527fd590d589be976_idx (discriminator), INDEX transaction_hash_9d60be1ae31861a527fd590d589be976_idx (transaction_hash), INDEX blame_id_9d60be1ae31861a527fd590d589be976_idx (blame_id), INDEX created_at_9d60be1ae31861a527fd590d589be976_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_e6e41b81419a01db7854bd453c13dc6d_idx (type), INDEX object_id_e6e41b81419a01db7854bd453c13dc6d_idx (object_id), INDEX discriminator_e6e41b81419a01db7854bd453c13dc6d_idx (discriminator), INDEX transaction_hash_e6e41b81419a01db7854bd453c13dc6d_idx (transaction_hash), INDEX blame_id_e6e41b81419a01db7854bd453c13dc6d_idx (blame_id), INDEX created_at_e6e41b81419a01db7854bd453c13dc6d_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE site_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_4e55cc8a840e69d5f46f1144f3d73db0_idx (type), INDEX object_id_4e55cc8a840e69d5f46f1144f3d73db0_idx (object_id), INDEX discriminator_4e55cc8a840e69d5f46f1144f3d73db0_idx (discriminator), INDEX transaction_hash_4e55cc8a840e69d5f46f1144f3d73db0_idx (transaction_hash), INDEX blame_id_4e55cc8a840e69d5f46f1144f3d73db0_idx (blame_id), INDEX created_at_4e55cc8a840e69d5f46f1144f3d73db0_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_request (id INT AUTO_INCREMENT NOT NULL, from_site_id INT NOT NULL, to_site_id INT NOT NULL, requested_by_id INT NOT NULL, approved_by_id INT DEFAULT NULL, status VARCHAR(50) NOT NULL, remarks LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_22319F3C70E3F5E9 (from_site_id), INDEX IDX_22319F3C78252BB3 (to_site_id), INDEX IDX_22319F3C4DA1E751 (requested_by_id), INDEX IDX_22319F3C2D234F6A (approved_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_request_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_73809603de7578f26fc82b37f446102e_idx (type), INDEX object_id_73809603de7578f26fc82b37f446102e_idx (object_id), INDEX discriminator_73809603de7578f26fc82b37f446102e_idx (discriminator), INDEX transaction_hash_73809603de7578f26fc82b37f446102e_idx (transaction_hash), INDEX blame_id_73809603de7578f26fc82b37f446102e_idx (blame_id), INDEX created_at_73809603de7578f26fc82b37f446102e_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_request_item (id INT AUTO_INCREMENT NOT NULL, stock_request_id INT NOT NULL, product_id INT NOT NULL, quantity_requested INT NOT NULL, quantity_approved INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_41D738F7EC374F09 (stock_request_id), INDEX IDX_41D738F74584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stock_request_item_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_489d1efcfce6a67bb8f45eddad145b83_idx (type), INDEX object_id_489d1efcfce6a67bb8f45eddad145b83_idx (object_id), INDEX discriminator_489d1efcfce6a67bb8f45eddad145b83_idx (discriminator), INDEX transaction_hash_489d1efcfce6a67bb8f45eddad145b83_idx (transaction_hash), INDEX blame_id_489d1efcfce6a67bb8f45eddad145b83_idx (blame_id), INDEX created_at_489d1efcfce6a67bb8f45eddad145b83_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, totp_secret VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8D93D649F6BD1646 (site_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, object_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, discriminator VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, transaction_hash VARCHAR(40) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_fqdn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, blame_user_firewall VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ip VARCHAR(45) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX type_e06395edc291d0719bee26fd39a32e8a_idx (type), INDEX object_id_e06395edc291d0719bee26fd39a32e8a_idx (object_id), INDEX discriminator_e06395edc291d0719bee26fd39a32e8a_idx (discriminator), INDEX transaction_hash_e06395edc291d0719bee26fd39a32e8a_idx (transaction_hash), INDEX blame_id_e06395edc291d0719bee26fd39a32e8a_idx (blame_id), INDEX created_at_e06395edc291d0719bee26fd39a32e8a_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD CONSTRAINT FK_22319F3C70E3F5E9 FOREIGN KEY (from_site_id) REFERENCES site (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD CONSTRAINT FK_22319F3C78252BB3 FOREIGN KEY (to_site_id) REFERENCES site (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD CONSTRAINT FK_22319F3C4DA1E751 FOREIGN KEY (requested_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request ADD CONSTRAINT FK_22319F3C2D234F6A FOREIGN KEY (approved_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_item ADD CONSTRAINT FK_41D738F7EC374F09 FOREIGN KEY (stock_request_id) REFERENCES stock_request (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_item ADD CONSTRAINT FK_41D738F74584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2
        SQL);
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
            ALTER TABLE stock_request_item DROP FOREIGN KEY FK_41D738F7EC374F09
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stock_request_item DROP FOREIGN KEY FK_41D738F74584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F6BD1646
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE site
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE site_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_request
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_request_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_request_item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stock_request_item_audit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_audit
        SQL);
    }
}
