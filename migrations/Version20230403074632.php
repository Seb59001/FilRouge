<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403074632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, sexe VARCHAR(50) NOT NULL, telephone VARCHAR(50) NOT NULL, emploi VARCHAR(50) NOT NULL, role VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C9E429CB0');
        $this->addSql('ALTER TABLE cours CHANGE user_cours_id user_cours_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C9E429CB0 FOREIGN KEY (user_cours_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE creneau DROP annee_scolaire');
        $this->addSql('ALTER TABLE users DROP nom, DROP prenom, DROP sexe, DROP telephone, DROP emploi, CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C9E429CB0');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C9E429CB0');
        $this->addSql('ALTER TABLE cours CHANGE user_cours_id user_cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C9E429CB0 FOREIGN KEY (user_cours_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE creneau ADD annee_scolaire VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\'');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74 ON users');
        $this->addSql('ALTER TABLE users ADD nom VARCHAR(50) DEFAULT NULL, ADD prenom VARCHAR(50) DEFAULT NULL, ADD sexe VARCHAR(50) DEFAULT NULL, ADD telephone VARCHAR(50) DEFAULT NULL, ADD emploi VARCHAR(50) DEFAULT NULL, CHANGE email email VARCHAR(50) NOT NULL, CHANGE roles roles VARCHAR(50) DEFAULT NULL');
    }
}
