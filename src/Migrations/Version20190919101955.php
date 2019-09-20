<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919101955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE race_result (id INT AUTO_INCREMENT NOT NULL, fastest_driver_in_quali_id INT NOT NULL, fastest_driver_in_race_id INT NOT NULL, first_place_driver_id INT NOT NULL, second_place_driver_id INT NOT NULL, third_place_driver_id INT NOT NULL, race_id INT NOT NULL, fastest_time VARCHAR(255) NOT NULL, tier_max VARCHAR(255) NOT NULL, is_enabled TINYINT(1) NOT NULL, INDEX IDX_793CDFC09D46E1A8 (fastest_driver_in_quali_id), INDEX IDX_793CDFC0E2D045D7 (fastest_driver_in_race_id), INDEX IDX_793CDFC01D39AE11 (first_place_driver_id), INDEX IDX_793CDFC0E4710F19 (second_place_driver_id), INDEX IDX_793CDFC096C8097C (third_place_driver_id), INDEX IDX_793CDFC06E59D40D (race_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE race_result ADD CONSTRAINT FK_793CDFC09D46E1A8 FOREIGN KEY (fastest_driver_in_quali_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_result ADD CONSTRAINT FK_793CDFC0E2D045D7 FOREIGN KEY (fastest_driver_in_race_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_result ADD CONSTRAINT FK_793CDFC01D39AE11 FOREIGN KEY (first_place_driver_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_result ADD CONSTRAINT FK_793CDFC0E4710F19 FOREIGN KEY (second_place_driver_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_result ADD CONSTRAINT FK_793CDFC096C8097C FOREIGN KEY (third_place_driver_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_result ADD CONSTRAINT FK_793CDFC06E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE race_result');
    }
}
