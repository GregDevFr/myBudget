<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620125505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE monthly_budget (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_905264B0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planned_transaction (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, monthly_budget_id INT NOT NULL, thirdparty_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_8A524338BCF5E72D (categorie_id), INDEX IDX_8A52433827EBA5CB (monthly_budget_id), INDEX IDX_8A524338C7D3A8E6 (thirdparty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thirdparty (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, INDEX IDX_9312E00BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, user_id INT NOT NULL, thirdparty_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, date DATE NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_723705D1BCF5E72D (categorie_id), INDEX IDX_723705D1A76ED395 (user_id), INDEX IDX_723705D1C7D3A8E6 (thirdparty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE monthly_budget ADD CONSTRAINT FK_905264B0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE planned_transaction ADD CONSTRAINT FK_8A524338BCF5E72D FOREIGN KEY (categorie_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE planned_transaction ADD CONSTRAINT FK_8A52433827EBA5CB FOREIGN KEY (monthly_budget_id) REFERENCES monthly_budget (id)');
        $this->addSql('ALTER TABLE planned_transaction ADD CONSTRAINT FK_8A524338C7D3A8E6 FOREIGN KEY (thirdparty_id) REFERENCES thirdparty (id)');
        $this->addSql('ALTER TABLE thirdparty ADD CONSTRAINT FK_9312E00BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C7D3A8E6 FOREIGN KEY (thirdparty_id) REFERENCES thirdparty (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monthly_budget DROP FOREIGN KEY FK_905264B0A76ED395');
        $this->addSql('ALTER TABLE planned_transaction DROP FOREIGN KEY FK_8A524338BCF5E72D');
        $this->addSql('ALTER TABLE planned_transaction DROP FOREIGN KEY FK_8A52433827EBA5CB');
        $this->addSql('ALTER TABLE planned_transaction DROP FOREIGN KEY FK_8A524338C7D3A8E6');
        $this->addSql('ALTER TABLE thirdparty DROP FOREIGN KEY FK_9312E00BA76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BCF5E72D');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C7D3A8E6');
        $this->addSql('DROP TABLE monthly_budget');
        $this->addSql('DROP TABLE planned_transaction');
        $this->addSql('DROP TABLE thirdparty');
        $this->addSql('DROP TABLE transaction');
    }
}
