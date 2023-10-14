<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230930101424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON images');
        $this->addSql('ALTER TABLE images ADD string BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', DROP id');
        $this->addSql('ALTER TABLE images ADD PRIMARY KEY (string)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD id INT AUTO_INCREMENT NOT NULL, DROP string, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
