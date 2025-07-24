<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 *
 */
final class OauthScopesColIdentifier extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        // remove the auto id int column and create a new column 'identifier' as a string
        $table = $this->table('oauth_scopes');
        $table
            ->addColumn('identifier', 'string', [
                'limit' => 100,
                'null' => false,
                'after' => 'id',
            ])
            ->save();
        $table->changePrimaryKey('identifier');
        $table->removeColumn('id')
            ->save();
    }
}
