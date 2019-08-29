<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829091604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE1A8C12F5');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP INDEX IDX_E52FFDEE1A8C12F5 ON orders');
        $this->addSql('ALTER TABLE orders DROP bill_id');
        $this->addSql('ALTER TABLE likes CHANGE dish_id dish_id INT NOT NULL');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D148EB0CB ON likes (dish_id)');
        $this->addSql('ALTER TABLE likes RENAME INDEX fk_49ca4e7da76ed395 TO IDX_49CA4E7DA76ED395');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957D8CB85E237E06 ON dish (name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_7A2119E3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('DROP INDEX UNIQ_957D8CB85E237E06 ON dish');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D148EB0CB');
        $this->addSql('DROP INDEX IDX_49CA4E7D148EB0CB ON likes');
        $this->addSql('ALTER TABLE likes CHANGE dish_id dish_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE likes RENAME INDEX idx_49ca4e7da76ed395 TO FK_49CA4E7DA76ED395');
        $this->addSql('ALTER TABLE orders ADD bill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE1A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE1A8C12F5 ON orders (bill_id)');
    }
}
