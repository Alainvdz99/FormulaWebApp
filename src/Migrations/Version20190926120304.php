<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190926120304 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE special_prediction_vote ADD race_id INT NOT NULL');
        $this->addSql('ALTER TABLE special_prediction_vote ADD CONSTRAINT FK_52E133EF6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('CREATE INDEX IDX_52E133EF6E59D40D ON special_prediction_vote (race_id)');
        $this->addSql('ALTER TABLE race_prediction DROP FOREIGN KEY FK_55E685511D9D9CD1');
        $this->addSql('DROP INDEX IDX_55E685511D9D9CD1 ON race_prediction');
        $this->addSql('ALTER TABLE race_prediction ADD is_enabled TINYINT(1) NOT NULL, CHANGE third_place_race_id third_place_driver_id INT NOT NULL');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E6855196C8097C FOREIGN KEY (third_place_driver_id) REFERENCES driver (id)');
        $this->addSql('CREATE INDEX IDX_55E6855196C8097C ON race_prediction (third_place_driver_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE race_prediction DROP FOREIGN KEY FK_55E6855196C8097C');
        $this->addSql('DROP INDEX IDX_55E6855196C8097C ON race_prediction');
        $this->addSql('ALTER TABLE race_prediction DROP is_enabled, CHANGE third_place_driver_id third_place_race_id INT NOT NULL');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E685511D9D9CD1 FOREIGN KEY (third_place_race_id) REFERENCES driver (id)');
        $this->addSql('CREATE INDEX IDX_55E685511D9D9CD1 ON race_prediction (third_place_race_id)');
        $this->addSql('ALTER TABLE special_prediction_vote DROP FOREIGN KEY FK_52E133EF6E59D40D');
        $this->addSql('DROP INDEX IDX_52E133EF6E59D40D ON special_prediction_vote');
        $this->addSql('ALTER TABLE special_prediction_vote DROP race_id');
    }
}
