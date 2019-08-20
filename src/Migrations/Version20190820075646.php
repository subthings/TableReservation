<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820075646 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tables ADD is_free TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEC6F6341A');
        $this->addSql('DROP INDEX IDX_E52FFDEEC6F6341A ON orders');
        $this->addSql('ALTER TABLE orders ADD reserved_table_id INT DEFAULT NULL, CHANGE table_reservation_id person_number INT NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEE946A430 FOREIGN KEY (reserved_table_id) REFERENCES tables (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEE946A430 ON orders (reserved_table_id)');
        $this->addSql('ALTER TABLE table_reservation ADD quantity INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEE946A430');
        $this->addSql('DROP INDEX IDX_E52FFDEEE946A430 ON orders');
        $this->addSql('ALTER TABLE orders DROP reserved_table_id, CHANGE person_number table_reservation_id INT NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEC6F6341A FOREIGN KEY (table_reservation_id) REFERENCES table_reservation (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEC6F6341A ON orders (table_reservation_id)');
        $this->addSql('ALTER TABLE table_reservation DROP quantity');
        $this->addSql('ALTER TABLE tables DROP is_free');
    }
}
