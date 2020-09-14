<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200914143123 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE \'transaction\' (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER DEFAULT NULL, trade_in_car_id INTEGER DEFAULT NULL, new_car_id INTEGER DEFAULT NULL, price BIGINT NOT NULL, currency VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_3C0242E119EB6921 ON \'transaction\' (client_id)');
        $this->addSql('CREATE INDEX IDX_3C0242E1536733C7 ON \'transaction\' (trade_in_car_id)');
        $this->addSql('CREATE INDEX IDX_3C0242E13B5CCEB5 ON \'transaction\' (new_car_id)');
        $this->addSql('CREATE TABLE car (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, showroom_id INTEGER DEFAULT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, new BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_773DE69D2243B88B ON car (showroom_id)');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE showroom (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, car_id INTEGER DEFAULT NULL, count INTEGER NOT NULL, price BIGINT NOT NULL, currency VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX car_idx ON showroom (car_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE \'transaction\'');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE showroom');
    }
}
