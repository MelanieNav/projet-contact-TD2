<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180214090512 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact ADD mobile VARCHAR(40) NOT NULL, CHANGE nom nom VARCHAR(30) NOT NULL, CHANGE prenom prenom VARCHAR(40) NOT NULL, CHANGE tel tel VARCHAR(10) NOT NULL, CHANGE email email VARCHAR(40) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP mobile, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE tel tel VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
