<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816051848 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE order_row (id INT AUTO_INCREMENT NOT NULL, dish_id INT NOT NULL, quanity INT NOT NULL, INDEX IDX_C76BB9BB148EB0CB (dish_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_row ADD CONSTRAINT FK_C76BB9BB148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('DROP TABLE cart_dish');
        $this->addSql('DROP TABLE order_dish');
        $this->addSql('ALTER TABLE tables CHANGE capacity capacity INT NOT NULL');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('DROP INDEX IDX_E52FFDEEA76ED395 ON orders');
        $this->addSql('ALTER TABLE orders ADD cart_id INT DEFAULT NULL, DROP user_id, DROP quanity');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE1AD5CDBF ON orders (cart_id)');
        $this->addSql('ALTER TABLE cart DROP INDEX UNIQ_BA388B7A76ED395, ADD INDEX IDX_BA388B7A76ED395 (user_id)');
        $this->addSql('ALTER TABLE cart DROP quanity');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart_dish (cart_id INT NOT NULL, dish_id INT NOT NULL, INDEX IDX_7A988C811AD5CDBF (cart_id), INDEX IDX_7A988C81148EB0CB (dish_id), PRIMARY KEY(cart_id, dish_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_dish (order_id INT NOT NULL, dish_id INT NOT NULL, INDEX IDX_D88CB6AF8D9F6D38 (order_id), INDEX IDX_D88CB6AF148EB0CB (dish_id), PRIMARY KEY(order_id, dish_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart_dish ADD CONSTRAINT FK_7A988C81148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_dish ADD CONSTRAINT FK_7A988C811AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_dish ADD CONSTRAINT FK_D88CB6AF148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE order_row');
        $this->addSql('ALTER TABLE cart DROP INDEX IDX_BA388B7A76ED395, ADD UNIQUE INDEX UNIQ_BA388B7A76ED395 (user_id)');
        $this->addSql('ALTER TABLE cart ADD quanity INT NOT NULL');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE1AD5CDBF');
        $this->addSql('DROP INDEX UNIQ_E52FFDEE1AD5CDBF ON orders');
        $this->addSql('ALTER TABLE orders ADD user_id INT NOT NULL, ADD quanity INT NOT NULL, DROP cart_id');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEA76ED395 ON orders (user_id)');
        $this->addSql('ALTER TABLE tables CHANGE capacity capacity DOUBLE PRECISION NOT NULL');
    }
}
