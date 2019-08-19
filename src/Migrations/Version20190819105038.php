<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190819105038 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE table_reservation (id INT AUTO_INCREMENT NOT NULL, picked_table_id INT NOT NULL, time_start DATETIME NOT NULL, time_end DATETIME NOT NULL, INDEX IDX_7196BAE8C4443056 (picked_table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE table_reservation ADD CONSTRAINT FK_7196BAE8C4443056 FOREIGN KEY (picked_table_id) REFERENCES tables (id)');
        $this->addSql('ALTER TABLE orders DROP date, DROP picked_table');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE table_reservation');
        $this->addSql('ALTER TABLE orders ADD date DATETIME NOT NULL, ADD picked_table VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
