<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831211959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Supression de la table category et ajout des tables article_category et recipe_category';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9312469DE2');
        $this->addSql('CREATE TABLE article_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_category_article (article_category_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_D2B6356B88C5F785 (article_category_id), INDEX IDX_D2B6356B7294869C (article_id), PRIMARY KEY(article_category_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_category_recipe (recipe_category_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_BC142E20C6B4D386 (recipe_category_id), INDEX IDX_BC142E2059D8A214 (recipe_id), PRIMARY KEY(recipe_category_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_category_article ADD CONSTRAINT FK_D2B6356B88C5F785 FOREIGN KEY (article_category_id) REFERENCES article_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_category_article ADD CONSTRAINT FK_D2B6356B7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_category_recipe ADD CONSTRAINT FK_BC142E20C6B4D386 FOREIGN KEY (recipe_category_id) REFERENCES recipe_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_category_recipe ADD CONSTRAINT FK_BC142E2059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_article DROP FOREIGN KEY FK_C5E24E1812469DE2');
        $this->addSql('ALTER TABLE category_article DROP FOREIGN KEY FK_C5E24E187294869C');
        $this->addSql('ALTER TABLE category_recipe DROP FOREIGN KEY FK_D5607B4C59D8A214');
        $this->addSql('ALTER TABLE category_recipe DROP FOREIGN KEY FK_D5607B4C12469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_article');
        $this->addSql('DROP TABLE category_recipe');
        $this->addSql('DROP INDEX IDX_7D053A9312469DE2 ON menu');
        $this->addSql('ALTER TABLE menu ADD recipe_category_id INT DEFAULT NULL, CHANGE category_id article_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9388C5F785 FOREIGN KEY (article_category_id) REFERENCES article_category (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93C6B4D386 FOREIGN KEY (recipe_category_id) REFERENCES recipe_category (id)');
        $this->addSql('CREATE INDEX IDX_7D053A9388C5F785 ON menu (article_category_id)');
        $this->addSql('CREATE INDEX IDX_7D053A93C6B4D386 ON menu (recipe_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9388C5F785');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93C6B4D386');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category_article (category_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_C5E24E1812469DE2 (category_id), INDEX IDX_C5E24E187294869C (article_id), PRIMARY KEY(category_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category_recipe (category_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_D5607B4C12469DE2 (category_id), INDEX IDX_D5607B4C59D8A214 (recipe_id), PRIMARY KEY(category_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE category_article ADD CONSTRAINT FK_C5E24E1812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_article ADD CONSTRAINT FK_C5E24E187294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_recipe ADD CONSTRAINT FK_D5607B4C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_recipe ADD CONSTRAINT FK_D5607B4C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_category_article DROP FOREIGN KEY FK_D2B6356B88C5F785');
        $this->addSql('ALTER TABLE article_category_article DROP FOREIGN KEY FK_D2B6356B7294869C');
        $this->addSql('ALTER TABLE recipe_category_recipe DROP FOREIGN KEY FK_BC142E20C6B4D386');
        $this->addSql('ALTER TABLE recipe_category_recipe DROP FOREIGN KEY FK_BC142E2059D8A214');
        $this->addSql('DROP TABLE article_category');
        $this->addSql('DROP TABLE article_category_article');
        $this->addSql('DROP TABLE recipe_category');
        $this->addSql('DROP TABLE recipe_category_recipe');
        $this->addSql('DROP INDEX IDX_7D053A9388C5F785 ON menu');
        $this->addSql('DROP INDEX IDX_7D053A93C6B4D386 ON menu');
        $this->addSql('ALTER TABLE menu ADD category_id INT DEFAULT NULL, DROP article_category_id, DROP recipe_category_id');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_7D053A9312469DE2 ON menu (category_id)');
    }
}
