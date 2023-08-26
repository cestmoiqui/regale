<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826001327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Suppression de la table Instructions (entité et repository)';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instructions DROP FOREIGN KEY FK_997D812BFDF2B1FA');
        $this->addSql('DROP TABLE instructions');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE instructions (id INT AUTO_INCREMENT NOT NULL, recipes_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_997D812BFDF2B1FA (recipes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE instructions ADD CONSTRAINT FK_997D812BFDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipe (id)');
    }
}
