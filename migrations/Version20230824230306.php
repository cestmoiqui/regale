<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824230306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversion_rate (id INT AUTO_INCREMENT NOT NULL, from_unit_id INT NOT NULL, to_unit_id INT NOT NULL, conversion_factor INT NOT NULL, INDEX IDX_BFE5241E7EE393A2 (from_unit_id), INDEX IDX_BFE5241E76254DF8 (to_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE measurement_units (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversion_rate ADD CONSTRAINT FK_BFE5241E7EE393A2 FOREIGN KEY (from_unit_id) REFERENCES measurement_units (id)');
        $this->addSql('ALTER TABLE conversion_rate ADD CONSTRAINT FK_BFE5241E76254DF8 FOREIGN KEY (to_unit_id) REFERENCES measurement_units (id)');
        $this->addSql('ALTER TABLE ingredients ADD default_unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114FA382148 FOREIGN KEY (default_unit_id) REFERENCES measurement_units (id)');
        $this->addSql('CREATE INDEX IDX_4B60114FA382148 ON ingredients (default_unit_id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13F8BD700D FOREIGN KEY (unit_id) REFERENCES measurement_units (id)');
        $this->addSql('CREATE INDEX IDX_22D1FE13F8BD700D ON recipe_ingredient (unit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY FK_4B60114FA382148');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13F8BD700D');
        $this->addSql('ALTER TABLE conversion_rate DROP FOREIGN KEY FK_BFE5241E7EE393A2');
        $this->addSql('ALTER TABLE conversion_rate DROP FOREIGN KEY FK_BFE5241E76254DF8');
        $this->addSql('DROP TABLE conversion_rate');
        $this->addSql('DROP TABLE measurement_units');
        $this->addSql('DROP INDEX IDX_4B60114FA382148 ON ingredients');
        $this->addSql('ALTER TABLE ingredients DROP default_unit_id');
        $this->addSql('DROP INDEX IDX_22D1FE13F8BD700D ON recipe_ingredient');
        $this->addSql('ALTER TABLE recipe_ingredient DROP unit_id');
    }
}
