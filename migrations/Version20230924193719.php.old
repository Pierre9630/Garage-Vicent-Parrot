<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230924193719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, cars_id_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, subject VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_4C62E638E509CDD1 (cars_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638E509CDD1 FOREIGN KEY (cars_id_id) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE cars ADD type_fuel VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638E509CDD1');
        $this->addSql('DROP TABLE contact');
        $this->addSql('ALTER TABLE cars DROP type_fuel');
    }
}
