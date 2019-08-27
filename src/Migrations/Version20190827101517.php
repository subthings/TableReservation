<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190827101517 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE like_user (like_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_54E60A37859BFA32 (like_id), INDEX IDX_54E60A37A76ED395 (user_id), PRIMARY KEY(like_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE like_dish (like_id INT NOT NULL, dish_id INT NOT NULL, INDEX IDX_4C0850C6859BFA32 (like_id), INDEX IDX_4C0850C6148EB0CB (dish_id), PRIMARY KEY(like_id, dish_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE like_user ADD CONSTRAINT FK_54E60A37859BFA32 FOREIGN KEY (like_id) REFERENCES likes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE like_user ADD CONSTRAINT FK_54E60A37A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE like_dish ADD CONSTRAINT FK_4C0850C6859BFA32 FOREIGN KEY (like_id) REFERENCES likes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE like_dish ADD CONSTRAINT FK_4C0850C6148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D148EB0CB');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DA76ED395');
        $this->addSql('DROP INDEX UNIQ_49CA4E7DA76ED395 ON likes');
        $this->addSql('DROP INDEX UNIQ_49CA4E7D148EB0CB ON likes');
        $this->addSql('ALTER TABLE likes DROP user_id, DROP dish_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE like_user');
        $this->addSql('DROP TABLE like_dish');
        $this->addSql('ALTER TABLE likes ADD user_id INT NOT NULL, ADD dish_id INT NOT NULL');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49CA4E7DA76ED395 ON likes (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49CA4E7D148EB0CB ON likes (dish_id)');
    }
}
