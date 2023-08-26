<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825095233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Suppression de la relation ManyToOne avec l\'entité recipe dans l\'entité steps et de la création de la relation OneToMany avec l\'entité steps dans l\'entité recipe ';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE steps DROP FOREIGN KEY FK_34220A72FDF2B1FA');
        $this->addSql('DROP INDEX IDX_34220A72FDF2B1FA ON steps');
        $this->addSql('ALTER TABLE steps ADD recipe_id INT NOT NULL, DROP recipes_id');
        $this->addSql('ALTER TABLE steps ADD CONSTRAINT FK_34220A7259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_34220A7259D8A214 ON steps (recipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE steps DROP FOREIGN KEY FK_34220A7259D8A214');
        $this->addSql('DROP INDEX IDX_34220A7259D8A214 ON steps');
        $this->addSql('ALTER TABLE steps ADD recipes_id INT DEFAULT NULL, DROP recipe_id');
        $this->addSql('ALTER TABLE steps ADD CONSTRAINT FK_34220A72FDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_34220A72FDF2B1FA ON steps (recipes_id)');
    }
}
