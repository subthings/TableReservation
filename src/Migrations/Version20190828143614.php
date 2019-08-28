<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828143614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D148EB0CB ON likes (dish_id)');
        $this->addSql('ALTER TABLE likes RENAME INDEX fk_49ca4e7da76ed395 TO IDX_49CA4E7DA76ED395');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D148EB0CB');
        $this->addSql('DROP INDEX IDX_49CA4E7D148EB0CB ON likes');
        $this->addSql('ALTER TABLE likes RENAME INDEX idx_49ca4e7da76ed395 TO FK_49CA4E7DA76ED395');
    }
}
