<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240907210152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contexto (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE palavra (id INT AUTO_INCREMENT NOT NULL, palavra VARCHAR(255) NOT NULL, contexto_id INT NOT NULL, INDEX IDX_1A3487D8F60E8AE2 (contexto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE palavra ADD CONSTRAINT FK_1A3487D8F60E8AE2 FOREIGN KEY (contexto_id) REFERENCES contexto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE palavra DROP FOREIGN KEY FK_1A3487D8F60E8AE2');
        $this->addSql('DROP TABLE contexto');
        $this->addSql('DROP TABLE palavra');
    }
}
