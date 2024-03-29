<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918083010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE race_prediction (id INT AUTO_INCREMENT NOT NULL, fastest_driver_in_quali_id INT NOT NULL, fastest_driver_in_race_id INT NOT NULL, first_place_driver_id INT NOT NULL, second_place_driver_id INT NOT NULL, third_place_race_id INT NOT NULL, user_id INT NOT NULL, race_id INT NOT NULL, fastest_time TIME NOT NULL, tier_max VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_55E685519D46E1A8 (fastest_driver_in_quali_id), INDEX IDX_55E68551E2D045D7 (fastest_driver_in_race_id), INDEX IDX_55E685511D39AE11 (first_place_driver_id), INDEX IDX_55E68551E4710F19 (second_place_driver_id), INDEX IDX_55E685511D9D9CD1 (third_place_race_id), INDEX IDX_55E68551A76ED395 (user_id), INDEX IDX_55E685516E59D40D (race_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E685519D46E1A8 FOREIGN KEY (fastest_driver_in_quali_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E68551E2D045D7 FOREIGN KEY (fastest_driver_in_race_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E685511D39AE11 FOREIGN KEY (first_place_driver_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E68551E4710F19 FOREIGN KEY (second_place_driver_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E685511D9D9CD1 FOREIGN KEY (third_place_race_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E68551A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE race_prediction ADD CONSTRAINT FK_55E685516E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE user ADD total_points INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE race_prediction');
        $this->addSql('ALTER TABLE user DROP total_points');
    }
}
