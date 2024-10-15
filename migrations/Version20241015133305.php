<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015133305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier ADD entrepot_id INT NOT NULL');
        $this->addSql('ALTER TABLE casier ADD CONSTRAINT FK_3FDF28572831E97 FOREIGN KEY (entrepot_id) REFERENCES entrepot (id)');
        $this->addSql('CREATE INDEX IDX_3FDF28572831E97 ON casier (entrepot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF28572831E97');
        $this->addSql('DROP INDEX IDX_3FDF28572831E97 ON casier');
        $this->addSql('ALTER TABLE casier DROP entrepot_id');
    }
}
