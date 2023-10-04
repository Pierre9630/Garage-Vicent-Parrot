<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230924084647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars ADD price INT NOT NULL, DROP type_fuel, CHANGE brand brand VARCHAR(100) NOT NULL, CHANGE model model VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8702F506');
        $this->addSql('DROP INDEX IDX_E01FBE6A8702F506 ON images');
        $this->addSql('ALTER TABLE images DROP path, CHANGE cars_id cars_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AE509CDD1 FOREIGN KEY (cars_id_id) REFERENCES cars (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AE509CDD1 ON images (cars_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars ADD type_fuel VARCHAR(255) NOT NULL, DROP price, CHANGE brand brand VARCHAR(255) NOT NULL, CHANGE model model VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AE509CDD1');
        $this->addSql('DROP INDEX IDX_E01FBE6AE509CDD1 ON images');
        $this->addSql('ALTER TABLE images ADD path VARCHAR(255) NOT NULL, CHANGE cars_id_id cars_id INT NOT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8702F506 FOREIGN KEY (cars_id) REFERENCES cars (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E01FBE6A8702F506 ON images (cars_id)');
    }
}
