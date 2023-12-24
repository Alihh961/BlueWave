<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231224233352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attributes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value_ LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_params (item_id INT NOT NULL, params_id INT NOT NULL, INDEX IDX_9377B3C126F525E (item_id), INDEX IDX_9377B3C339CCA0F (params_id), PRIMARY KEY(item_id, params_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_params ADD CONSTRAINT FK_9377B3C126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_params ADD CONSTRAINT FK_9377B3C339CCA0F FOREIGN KEY (params_id) REFERENCES params (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item ADD attributes_id INT NOT NULL, ADD item_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EBAAF4009 FOREIGN KEY (attributes_id) REFERENCES attributes (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ECE11AAC7 FOREIGN KEY (item_type_id) REFERENCES item_type (id)');
        $this->addSql('CREATE INDEX IDX_1F1B251EBAAF4009 ON item (attributes_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251ECE11AAC7 ON item (item_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EBAAF4009');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251ECE11AAC7');
        $this->addSql('ALTER TABLE item_params DROP FOREIGN KEY FK_9377B3C126F525E');
        $this->addSql('ALTER TABLE item_params DROP FOREIGN KEY FK_9377B3C339CCA0F');
        $this->addSql('DROP TABLE attributes');
        $this->addSql('DROP TABLE item_params');
        $this->addSql('DROP TABLE item_type');
        $this->addSql('DROP INDEX IDX_1F1B251EBAAF4009 ON item');
        $this->addSql('DROP INDEX IDX_1F1B251ECE11AAC7 ON item');
        $this->addSql('ALTER TABLE item DROP attributes_id, DROP item_type_id');
    }
}
