<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Class OauthClientsTable
 */
class OauthClientsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('oauth_clients');
        $table
            ->addColumn('identifier', 'string', ['limit' => 255])
            ->addColumn('name', 'string', [])
            ->addColumn('secret', 'string', ['limit' => 100])
            ->addColumn('redirect_uri', 'string', [])
            ->addColumn('grant_types', 'enum', [
                'values' => ['authorization_code', 'personal_access', 'password', 'password']
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime', ['null' => true])
            ->addIndex(['identifier'], ['unique' => true])
            ->create();
    }
}
