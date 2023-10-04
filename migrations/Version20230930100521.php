<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230930100521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cars (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', brand VARCHAR(100) NOT NULL, model VARCHAR(100) NOT NULL, year INT NOT NULL, kilometers INT NOT NULL, price INT NOT NULL, description LONGTEXT DEFAULT NULL, type_fuel VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', offer_id INT NOT NULL, email VARCHAR(180) NOT NULL, subject VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_3340157353C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A53C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offers (id INT AUTO_INCREMENT NOT NULL, car_id_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', reference VARCHAR(100) NOT NULL, offer_title VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_DA460427A0EF1B80 (car_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_3340157353C674EE FOREIGN KEY (offer_id) REFERENCES offers (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A53C674EE FOREIGN KEY (offer_id) REFERENCES offers (id)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA460427A0EF1B80 FOREIGN KEY (car_id_id) REFERENCES cars (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_3340157353C674EE');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A53C674EE');
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA460427A0EF1B80');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE offers');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
