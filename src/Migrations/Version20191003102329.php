<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191003102329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE special_prediction_result (id INT AUTO_INCREMENT NOT NULL, special_prediction_id INT DEFAULT NULL, happened TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E91F9EDB3D998394 (special_prediction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE special_prediction_result ADD CONSTRAINT FK_E91F9EDB3D998394 FOREIGN KEY (special_prediction_id) REFERENCES special_prediction (id)');
        $this->addSql('ALTER TABLE special_prediction DROP is_happened');
        $this->addSql('CREATE UNIQUE INDEX unique_prediction ON special_prediction (race_id, created_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE special_prediction_result');
        $this->addSql('DROP INDEX unique_prediction ON special_prediction');
        $this->addSql('ALTER TABLE special_prediction ADD is_happened TINYINT(1) DEFAULT NULL');
    }
}
