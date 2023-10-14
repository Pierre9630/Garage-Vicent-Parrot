<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230930150606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA460427A0EF1B80');
        $this->addSql('DROP INDEX UNIQ_DA460427A0EF1B80 ON offers');
        $this->addSql('ALTER TABLE offers CHANGE car_id_id car_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA460427C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA460427C3C6F69F ON offers (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA460427C3C6F69F');
        $this->addSql('DROP INDEX UNIQ_DA460427C3C6F69F ON offers');
        $this->addSql('ALTER TABLE offers CHANGE car_id car_id_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA460427A0EF1B80 FOREIGN KEY (car_id_id) REFERENCES cars (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA460427A0EF1B80 ON offers (car_id_id)');
    }
}
