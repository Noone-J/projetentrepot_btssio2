<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015123153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE distance ADD ville_id INT NOT NULL, ADD entrepot_id INT NOT NULL');
        $this->addSql('ALTER TABLE distance ADD CONSTRAINT FK_1C929A81A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE distance ADD CONSTRAINT FK_1C929A8172831E97 FOREIGN KEY (entrepot_id) REFERENCES entrepot (id)');
        $this->addSql('CREATE INDEX IDX_1C929A81A73F0036 ON distance (ville_id)');
        $this->addSql('CREATE INDEX IDX_1C929A8172831E97 ON distance (entrepot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE distance DROP FOREIGN KEY FK_1C929A81A73F0036');
        $this->addSql('ALTER TABLE distance DROP FOREIGN KEY FK_1C929A8172831E97');
        $this->addSql('DROP INDEX IDX_1C929A81A73F0036 ON distance');
        $this->addSql('DROP INDEX IDX_1C929A8172831E97 ON distance');
        $this->addSql('ALTER TABLE distance DROP ville_id, DROP entrepot_id');
    }
}
