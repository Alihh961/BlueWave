<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231225173724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vision_item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, attributes_id INT NOT NULL, item_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, available TINYINT(1) NOT NULL, vision_id INT NOT NULL, INDEX IDX_9D74B25812469DE2 (category_id), INDEX IDX_9D74B258BAAF4009 (attributes_id), INDEX IDX_9D74B258CE11AAC7 (item_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vision_item_params (vision_item_id INT NOT NULL, params_id INT NOT NULL, INDEX IDX_72BD83A88575C3BA (vision_item_id), INDEX IDX_72BD83A8339CCA0F (params_id), PRIMARY KEY(vision_item_id, params_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vision_item ADD CONSTRAINT FK_9D74B25812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE vision_item ADD CONSTRAINT FK_9D74B258BAAF4009 FOREIGN KEY (attributes_id) REFERENCES attributes (id)');
        $this->addSql('ALTER TABLE vision_item ADD CONSTRAINT FK_9D74B258CE11AAC7 FOREIGN KEY (item_type_id) REFERENCES item_type (id)');
        $this->addSql('ALTER TABLE vision_item_params ADD CONSTRAINT FK_72BD83A88575C3BA FOREIGN KEY (vision_item_id) REFERENCES vision_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vision_item_params ADD CONSTRAINT FK_72BD83A8339CCA0F FOREIGN KEY (params_id) REFERENCES params (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E12469DE2');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EBAAF4009');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251ECE11AAC7');
        $this->addSql('ALTER TABLE item_params DROP FOREIGN KEY FK_9377B3C126F525E');
        $this->addSql('ALTER TABLE item_params DROP FOREIGN KEY FK_9377B3C339CCA0F');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_params');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, attributes_id INT NOT NULL, item_type_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price NUMERIC(10, 2) NOT NULL, available TINYINT(1) NOT NULL, vision_id INT NOT NULL, INDEX IDX_1F1B251E12469DE2 (category_id), INDEX IDX_1F1B251EBAAF4009 (attributes_id), INDEX IDX_1F1B251ECE11AAC7 (item_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE item_params (item_id INT NOT NULL, params_id INT NOT NULL, INDEX IDX_9377B3C126F525E (item_id), INDEX IDX_9377B3C339CCA0F (params_id), PRIMARY KEY(item_id, params_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EBAAF4009 FOREIGN KEY (attributes_id) REFERENCES attributes (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ECE11AAC7 FOREIGN KEY (item_type_id) REFERENCES item_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE item_params ADD CONSTRAINT FK_9377B3C126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_params ADD CONSTRAINT FK_9377B3C339CCA0F FOREIGN KEY (params_id) REFERENCES params (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vision_item DROP FOREIGN KEY FK_9D74B25812469DE2');
        $this->addSql('ALTER TABLE vision_item DROP FOREIGN KEY FK_9D74B258BAAF4009');
        $this->addSql('ALTER TABLE vision_item DROP FOREIGN KEY FK_9D74B258CE11AAC7');
        $this->addSql('ALTER TABLE vision_item_params DROP FOREIGN KEY FK_72BD83A88575C3BA');
        $this->addSql('ALTER TABLE vision_item_params DROP FOREIGN KEY FK_72BD83A8339CCA0F');
        $this->addSql('DROP TABLE vision_item');
        $this->addSql('DROP TABLE vision_item_params');
    }
}
