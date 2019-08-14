<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190814092106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398ECFF285C');
        $this->addSql('DROP INDEX IDX_F5299398ECFF285C ON `order`');
        $this->addSql('ALTER TABLE `order` ADD picked_table VARCHAR(255) NOT NULL, DROP table_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` ADD table_id INT DEFAULT NULL, DROP picked_table');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398ECFF285C FOREIGN KEY (table_id) REFERENCES tables (id)');
        $this->addSql('CREATE INDEX IDX_F5299398ECFF285C ON `order` (table_id)');
    }
}
