<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017065930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compartiment ADD le_casier_id INT DEFAULT NULL, ADD le_colis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compartiment ADD CONSTRAINT FK_7BEEB8A9BD210531 FOREIGN KEY (le_casier_id) REFERENCES casier (id)');
        $this->addSql('ALTER TABLE compartiment ADD CONSTRAINT FK_7BEEB8A98368A699 FOREIGN KEY (le_colis_id) REFERENCES colis (id)');
        $this->addSql('CREATE INDEX IDX_7BEEB8A9BD210531 ON compartiment (le_casier_id)');
        $this->addSql('CREATE INDEX IDX_7BEEB8A98368A699 ON compartiment (le_colis_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compartiment DROP FOREIGN KEY FK_7BEEB8A9BD210531');
        $this->addSql('ALTER TABLE compartiment DROP FOREIGN KEY FK_7BEEB8A98368A699');
        $this->addSql('DROP INDEX IDX_7BEEB8A9BD210531 ON compartiment');
        $this->addSql('DROP INDEX IDX_7BEEB8A98368A699 ON compartiment');
        $this->addSql('ALTER TABLE compartiment DROP le_casier_id, DROP le_colis_id');
    }
}
