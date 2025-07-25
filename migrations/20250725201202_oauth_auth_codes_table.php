<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 *
 */
final class OauthAuthCodesTable extends AbstractMigration
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
        $this
            ->table('oauth_auth_codes', [])
            ->addColumn('identifier', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('client_id', 'integer', ['null' => false,])
            ->addColumn('user_id', 'string', ['limit' => 100, 'null' => false,])
            ->addColumn('redirect_uri', 'string', [])
            ->addColumn('scopes', 'text', [
                'null' => true,
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => false,
            ])
            ->addColumn('expires_at', 'datetime', [])
            ->addColumn('created_at', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
            ])
            ->addIndex(['identifier'], ['unique' => true])
            ->addIndex(['user_id'], [])
            ->addIndex(['client_id'], [])
            ->addForeignKey(
                'client_id',
                'oauth_clients',
                'id',
                [
                    'constraint' => 'oauth_clients_client_id_clients',
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION',
                ]
            )
            ->save();
    }
}
