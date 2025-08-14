<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class OauthClientsRedirectUriText extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('oauth_clients');
        if ($table->hasColumn('redirect_uri')) {
            // Change to TEXT to allow storing multiple URIs (comma/whitespace delimited or JSON)
            $table->changeColumn('redirect_uri', 'text', ['null' => true]);
            $table->save();
        }
    }
}
