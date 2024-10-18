<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018071751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE casier (id INT AUTO_INCREMENT NOT NULL, l_entrepot_id INT DEFAULT NULL, status TINYINT(1) NOT NULL, taille INT NOT NULL, INDEX IDX_3FDF285CCD64F21 (l_entrepot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colis (id INT AUTO_INCREMENT NOT NULL, la_ville_id INT DEFAULT NULL, taille INT NOT NULL, reference VARCHAR(255) NOT NULL, INDEX IDX_470BDFF9609A8BA5 (la_ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compartiment (id INT AUTO_INCREMENT NOT NULL, le_casier_id INT DEFAULT NULL, le_colis_id INT DEFAULT NULL, status TINYINT(1) NOT NULL, contenu INT DEFAULT NULL, INDEX IDX_7BEEB8A9BD210531 (le_casier_id), INDEX IDX_7BEEB8A98368A699 (le_colis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE distance (id INT AUTO_INCREMENT NOT NULL, l_entrepot_id INT DEFAULT NULL, la_ville_id INT DEFAULT NULL, kilometres INT NOT NULL, INDEX IDX_1C929A81CCD64F21 (l_entrepot_id), INDEX IDX_1C929A81609A8BA5 (la_ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrepot (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, entrepot_nb_casier INT NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE casier ADD CONSTRAINT FK_3FDF285CCD64F21 FOREIGN KEY (l_entrepot_id) REFERENCES entrepot (id)');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF9609A8BA5 FOREIGN KEY (la_ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE compartiment ADD CONSTRAINT FK_7BEEB8A9BD210531 FOREIGN KEY (le_casier_id) REFERENCES casier (id)');
        $this->addSql('ALTER TABLE compartiment ADD CONSTRAINT FK_7BEEB8A98368A699 FOREIGN KEY (le_colis_id) REFERENCES colis (id)');
        $this->addSql('ALTER TABLE distance ADD CONSTRAINT FK_1C929A81CCD64F21 FOREIGN KEY (l_entrepot_id) REFERENCES entrepot (id)');
        $this->addSql('ALTER TABLE distance ADD CONSTRAINT FK_1C929A81609A8BA5 FOREIGN KEY (la_ville_id) REFERENCES ville (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF285CCD64F21');
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF9609A8BA5');
        $this->addSql('ALTER TABLE compartiment DROP FOREIGN KEY FK_7BEEB8A9BD210531');
        $this->addSql('ALTER TABLE compartiment DROP FOREIGN KEY FK_7BEEB8A98368A699');
        $this->addSql('ALTER TABLE distance DROP FOREIGN KEY FK_1C929A81CCD64F21');
        $this->addSql('ALTER TABLE distance DROP FOREIGN KEY FK_1C929A81609A8BA5');
        $this->addSql('DROP TABLE casier');
        $this->addSql('DROP TABLE colis');
        $this->addSql('DROP TABLE compartiment');
        $this->addSql('DROP TABLE distance');
        $this->addSql('DROP TABLE entrepot');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
