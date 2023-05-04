<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502132552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, user_cours_id INT NOT NULL, libelee_cour VARCHAR(100) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_FDCA8C9C9E429CB0 (user_cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours_eleve (cours_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_DCC78C217ECF78B0 (cours_id), INDEX IDX_DCC78C21A6CC7B2 (eleve_id), PRIMARY KEY(cours_id, eleve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneau (id INT AUTO_INCREMENT NOT NULL, appartient_cours_id INT DEFAULT NULL, date_debut_cours DATETIME NOT NULL, date_fin_cours DATETIME NOT NULL, all_day TINYINT(1) NOT NULL, INDEX IDX_F9668B5F731BB849 (appartient_cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, niveau_etude VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presence (id INT AUTO_INCREMENT NOT NULL, presence_eleve_id INT NOT NULL, presence_cours_id INT NOT NULL, date_presence DATE NOT NULL, present TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_6977C7A5FCC8BB68 (presence_eleve_id), INDEX IDX_6977C7A5886B046A (presence_cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, auth_code VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, sexe VARCHAR(50) NOT NULL, telephone VARCHAR(50) NOT NULL, emploi VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C9E429CB0 FOREIGN KEY (user_cours_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE cours_eleve ADD CONSTRAINT FK_DCC78C217ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_eleve ADD CONSTRAINT FK_DCC78C21A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F731BB849 FOREIGN KEY (appartient_cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5FCC8BB68 FOREIGN KEY (presence_eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5886B046A FOREIGN KEY (presence_cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C9E429CB0');
        $this->addSql('ALTER TABLE cours_eleve DROP FOREIGN KEY FK_DCC78C217ECF78B0');
        $this->addSql('ALTER TABLE cours_eleve DROP FOREIGN KEY FK_DCC78C21A6CC7B2');
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5F731BB849');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5FCC8BB68');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5886B046A');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_eleve');
        $this->addSql('DROP TABLE creneau');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE presence');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
