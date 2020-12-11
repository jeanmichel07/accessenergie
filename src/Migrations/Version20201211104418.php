<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201211104418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail_offre_elec (id INT AUTO_INCREMENT NOT NULL, offre_id INT DEFAULT NULL, pr_abonnement_par_an VARCHAR(100) DEFAULT NULL, pr_pte VARCHAR(100) DEFAULT NULL, pr_hph VARCHAR(100) DEFAULT NULL, pr_hch VARCHAR(100) DEFAULT NULL, pr_hpe VARCHAR(100) DEFAULT NULL, pr_hce VARCHAR(100) DEFAULT NULL, budget_htt VARCHAR(100) DEFAULT NULL, INDEX IDX_59084BCB4CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_electricite (id INT AUTO_INCREMENT NOT NULL, fournisseur VARCHAR(255) DEFAULT NULL, segmentation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail_offre_elec ADD CONSTRAINT FK_59084BCB4CC8505A FOREIGN KEY (offre_id) REFERENCES offre_electricite (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_offre_elec DROP FOREIGN KEY FK_59084BCB4CC8505A');
        $this->addSql('DROP TABLE detail_offre_elec');
        $this->addSql('DROP TABLE offre_electricite');
    }
}
