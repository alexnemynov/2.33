<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201120127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $transactions = $schema->createTable('transactions');

        $transactions->addColumn('id', 'integer', ['autoincrement' => true]);
        $transactions->addColumn('date', 'date', ['notnull' => false]);
        $transactions->addColumn('checkNumber', 'integer', ['notnull' => false]);
        $transactions->addColumn('description', 'varchar(255)', ['notnull' => false]);
        $transactions->addColumn('amount', 'float', ['notnull' => false]);

        $transactions->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('transactions');
    }
}
