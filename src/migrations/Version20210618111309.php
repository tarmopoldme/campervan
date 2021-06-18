<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618111309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Test migration to check database connection';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('SELECT 1;');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
