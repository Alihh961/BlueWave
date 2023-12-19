<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219084617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_status_history ADD _order_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_status_history ADD CONSTRAINT FK_471AD77EA35F2858 FOREIGN KEY (_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_471AD77EA35F2858 ON order_status_history (_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_status_history DROP FOREIGN KEY FK_471AD77EA35F2858');
        $this->addSql('DROP INDEX IDX_471AD77EA35F2858 ON order_status_history');
        $this->addSql('ALTER TABLE order_status_history DROP _order_id');
    }
}
