<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210902064354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD category_id INT DEFAULT NULL, DROP category');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id), ADD price DOUBLE PRECISION DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE INDEX UNIQ_D34A04AD12469DE2 ON product (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2, DROP price, DROP description');
        $this->addSql('DROP INDEX UNIQ_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product ADD category INT NOT NULL, DROP category_id');
    }
}
