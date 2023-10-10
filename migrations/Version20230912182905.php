<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230912182905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add step_id to recipe_ingredient table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_ingredient ADD step_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE1373B21E9C FOREIGN KEY (step_id) REFERENCES steps (id)');
        $this->addSql('CREATE INDEX IDX_22D1FE1373B21E9C ON recipe_ingredient (step_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE1373B21E9C');
        $this->addSql('DROP INDEX IDX_22D1FE1373B21E9C ON recipe_ingredient');
        $this->addSql('ALTER TABLE recipe_ingredient DROP step_id');
    }
}
