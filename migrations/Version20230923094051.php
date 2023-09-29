<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923094051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars DROP updated_at, CHANGE brand brand VARCHAR(255) NOT NULL, CHANGE model model VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE type_fuel type_fuel VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE images ADD path VARCHAR(255) NOT NULL, DROP image_file, CHANGE cars_id cars_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE brand brand VARCHAR(50) NOT NULL, CHANGE model model VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE type_fuel type_fuel VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE images ADD image_file LONGBLOB NOT NULL, DROP path, CHANGE cars_id cars_id INT DEFAULT NULL');
    }
}
