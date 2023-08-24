<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821185147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des entités';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, featured_text VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_article (category_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_C5E24E1812469DE2 (category_id), INDEX IDX_C5E24E187294869C (article_id), PRIMARY KEY(category_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_recipe (category_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_D5607B4C12469DE2 (category_id), INDEX IDX_D5607B4C59D8A214 (recipe_id), PRIMARY KEY(category_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, commentable_id INT NOT NULL, commentable_type VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE difficulties (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredients (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instructions (id INT AUTO_INCREMENT NOT NULL, recipes_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_997D812BFDF2B1FA (recipes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alt_text VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) NOT NULL, type VARCHAR(100) NOT NULL, media_owner_id INT NOT NULL, media_owner_type VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, recipe_id INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, menu_order INT DEFAULT NULL, is_visible TINYINT(1) NOT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_7D053A937294869C (article_id), INDEX IDX_7D053A9359D8A214 (recipe_id), INDEX IDX_7D053A9312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_menu (menu_source INT NOT NULL, menu_target INT NOT NULL, INDEX IDX_B54ACADD8CCD27AB (menu_source), INDEX IDX_B54ACADD95287724 (menu_target), PRIMARY KEY(menu_source, menu_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, difficulty_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, featured_text VARCHAR(100) DEFAULT NULL, cook_time TIME NOT NULL, yield_quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_DA88B137FCFA9DAE (difficulty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, recipes_id INT NOT NULL, ingredients_id INT NOT NULL, quantity INT DEFAULT NULL, measure VARCHAR(255) DEFAULT NULL, INDEX IDX_22D1FE13FDF2B1FA (recipes_id), INDEX IDX_22D1FE133EC4DCE (ingredients_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE steps (id INT AUTO_INCREMENT NOT NULL, recipes_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_34220A72FDF2B1FA (recipes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_article ADD CONSTRAINT FK_C5E24E1812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_article ADD CONSTRAINT FK_C5E24E187294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_recipe ADD CONSTRAINT FK_D5607B4C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_recipe ADD CONSTRAINT FK_D5607B4C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instructions ADD CONSTRAINT FK_997D812BFDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A937294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE menu_menu ADD CONSTRAINT FK_B54ACADD8CCD27AB FOREIGN KEY (menu_source) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_menu ADD CONSTRAINT FK_B54ACADD95287724 FOREIGN KEY (menu_target) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES difficulties (id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13FDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE133EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id)');
        $this->addSql('ALTER TABLE steps ADD CONSTRAINT FK_34220A72FDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_article DROP FOREIGN KEY FK_C5E24E1812469DE2');
        $this->addSql('ALTER TABLE category_article DROP FOREIGN KEY FK_C5E24E187294869C');
        $this->addSql('ALTER TABLE category_recipe DROP FOREIGN KEY FK_D5607B4C12469DE2');
        $this->addSql('ALTER TABLE category_recipe DROP FOREIGN KEY FK_D5607B4C59D8A214');
        $this->addSql('ALTER TABLE instructions DROP FOREIGN KEY FK_997D812BFDF2B1FA');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A937294869C');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9359D8A214');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9312469DE2');
        $this->addSql('ALTER TABLE menu_menu DROP FOREIGN KEY FK_B54ACADD8CCD27AB');
        $this->addSql('ALTER TABLE menu_menu DROP FOREIGN KEY FK_B54ACADD95287724');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137FCFA9DAE');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13FDF2B1FA');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE133EC4DCE');
        $this->addSql('ALTER TABLE steps DROP FOREIGN KEY FK_34220A72FDF2B1FA');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_article');
        $this->addSql('DROP TABLE category_recipe');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE difficulties');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE instructions');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_menu');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_ingredient');
        $this->addSql('DROP TABLE steps');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
