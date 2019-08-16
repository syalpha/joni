<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190814155554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260AF4523FC');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260AF4523FC FOREIGN KEY (idprestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF4523FC');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF4523FC FOREIGN KEY (idprestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1786A81FB');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D18CDECFD5');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D18CDECFD5 FOREIGN KEY (idcompte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260AF4523FC');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260AF4523FC FOREIGN KEY (idprestataire_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1786A81FB');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D18CDECFD5');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1786A81FB FOREIGN KEY (iduser_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D18CDECFD5 FOREIGN KEY (idcompte_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF4523FC');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF4523FC FOREIGN KEY (idprestataire_id) REFERENCES user (id)');
    }
}
