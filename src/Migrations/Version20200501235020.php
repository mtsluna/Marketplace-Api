<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501235020 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, street VARCHAR(255) NOT NULL, number INT NOT NULL, postal_code VARCHAR(15) NOT NULL, INDEX IDX_D4E6F818BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, state_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B02345D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, dni BIGINT NOT NULL, UNIQUE INDEX UNIQ_C7440455F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, store_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_D34A04ADB092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_detail_union (product_id INT NOT NULL, detail_id INT NOT NULL, INDEX IDX_D3D43A384584665A (product_id), UNIQUE INDEX UNIQ_D3D43A38D8D003BB (detail_id), PRIMARY KEY(product_id, detail_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_detail (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A393D2FBF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, cuil VARCHAR(15) NOT NULL, business_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FF575877F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02345D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE product_detail_union ADD CONSTRAINT FK_D3D43A384584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_detail_union ADD CONSTRAINT FK_D3D43A38D8D003BB FOREIGN KEY (detail_id) REFERENCES product_detail (id)');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455F5B7AF75');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877F5B7AF75');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FBF92F3E70');
        $this->addSql('ALTER TABLE product_detail_union DROP FOREIGN KEY FK_D3D43A384584665A');
        $this->addSql('ALTER TABLE product_detail_union DROP FOREIGN KEY FK_D3D43A38D8D003BB');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02345D83CC1');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB092A811');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_detail_union');
        $this->addSql('DROP TABLE product_detail');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE store');
    }
}
