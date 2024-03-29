<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923172447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE box (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, short VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE temp_buero');
        $this->addSql('DROP TABLE temp_schlafzimmer');
        $this->addSql('DROP TABLE temp_wohnzimmer');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE temp_buero (stamp BIGINT NOT NULL, temp NUMERIC(10, 2) NOT NULL, `set` NUMERIC(10, 2) NOT NULL, valve INT NOT NULL, UNIQUE INDEX time (stamp)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE temp_schlafzimmer (stamp BIGINT NOT NULL, temp NUMERIC(10, 2) NOT NULL, `set` NUMERIC(10, 2) NOT NULL, valve DOUBLE PRECISION NOT NULL, UNIQUE INDEX time (stamp)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE temp_wohnzimmer (stamp BIGINT NOT NULL, temp NUMERIC(10, 2) NOT NULL, `set` NUMERIC(10, 2) NOT NULL, valve DOUBLE PRECISION NOT NULL, UNIQUE INDEX time (stamp)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE box');
    }
}
