<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017110153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier ADD l_entrepot_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE casier ADD CONSTRAINT FK_3FDF285CCD64F21 FOREIGN KEY (l_entrepot_id) REFERENCES entrepot (id)');
        $this->addSql('CREATE INDEX IDX_3FDF285CCD64F21 ON casier (l_entrepot_id)');
        $this->addSql('ALTER TABLE colis ADD la_ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF9609A8BA5 FOREIGN KEY (la_ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_470BDFF9609A8BA5 ON colis (la_ville_id)');
        $this->addSql('ALTER TABLE compartiment ADD le_casier_id INT DEFAULT NULL, ADD le_colis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compartiment ADD CONSTRAINT FK_7BEEB8A9BD210531 FOREIGN KEY (le_casier_id) REFERENCES casier (id)');
        $this->addSql('ALTER TABLE compartiment ADD CONSTRAINT FK_7BEEB8A98368A699 FOREIGN KEY (le_colis_id) REFERENCES colis (id)');
        $this->addSql('CREATE INDEX IDX_7BEEB8A9BD210531 ON compartiment (le_casier_id)');
        $this->addSql('CREATE INDEX IDX_7BEEB8A98368A699 ON compartiment (le_colis_id)');
        $this->addSql('ALTER TABLE distance ADD l_entrepot_id INT DEFAULT NULL, ADD la_ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE distance ADD CONSTRAINT FK_1C929A81CCD64F21 FOREIGN KEY (l_entrepot_id) REFERENCES entrepot (id)');
        $this->addSql('ALTER TABLE distance ADD CONSTRAINT FK_1C929A81609A8BA5 FOREIGN KEY (la_ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_1C929A81CCD64F21 ON distance (l_entrepot_id)');
        $this->addSql('CREATE INDEX IDX_1C929A81609A8BA5 ON distance (la_ville_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF285CCD64F21');
        $this->addSql('DROP INDEX IDX_3FDF285CCD64F21 ON casier');
        $this->addSql('ALTER TABLE casier DROP l_entrepot_id');
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF9609A8BA5');
        $this->addSql('DROP INDEX IDX_470BDFF9609A8BA5 ON colis');
        $this->addSql('ALTER TABLE colis DROP la_ville_id');
        $this->addSql('ALTER TABLE compartiment DROP FOREIGN KEY FK_7BEEB8A9BD210531');
        $this->addSql('ALTER TABLE compartiment DROP FOREIGN KEY FK_7BEEB8A98368A699');
        $this->addSql('DROP INDEX IDX_7BEEB8A9BD210531 ON compartiment');
        $this->addSql('DROP INDEX IDX_7BEEB8A98368A699 ON compartiment');
        $this->addSql('ALTER TABLE compartiment DROP le_casier_id, DROP le_colis_id');
        $this->addSql('ALTER TABLE distance DROP FOREIGN KEY FK_1C929A81CCD64F21');
        $this->addSql('ALTER TABLE distance DROP FOREIGN KEY FK_1C929A81609A8BA5');
        $this->addSql('DROP INDEX IDX_1C929A81CCD64F21 ON distance');
        $this->addSql('DROP INDEX IDX_1C929A81609A8BA5 ON distance');
        $this->addSql('ALTER TABLE distance DROP l_entrepot_id, DROP la_ville_id');
    }
}
