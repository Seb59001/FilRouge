<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329110822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours_eleve (cours_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_DCC78C217ECF78B0 (cours_id), INDEX IDX_DCC78C21A6CC7B2 (eleve_id), PRIMARY KEY(cours_id, eleve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours_eleve ADD CONSTRAINT FK_DCC78C217ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_eleve ADD CONSTRAINT FK_DCC78C21A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours ADD user_cours_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C9E429CB0 FOREIGN KEY (user_cours_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C9E429CB0 ON cours (user_cours_id)');
        $this->addSql('ALTER TABLE creneau ADD appartient_cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F731BB849 FOREIGN KEY (appartient_cours_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_F9668B5F731BB849 ON creneau (appartient_cours_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours_eleve DROP FOREIGN KEY FK_DCC78C217ECF78B0');
        $this->addSql('ALTER TABLE cours_eleve DROP FOREIGN KEY FK_DCC78C21A6CC7B2');
        $this->addSql('DROP TABLE cours_eleve');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C9E429CB0');
        $this->addSql('DROP INDEX IDX_FDCA8C9C9E429CB0 ON cours');
        $this->addSql('ALTER TABLE cours DROP user_cours_id');
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5F731BB849');
        $this->addSql('DROP INDEX IDX_F9668B5F731BB849 ON creneau');
        $this->addSql('ALTER TABLE creneau DROP appartient_cours_id');
    }
}
