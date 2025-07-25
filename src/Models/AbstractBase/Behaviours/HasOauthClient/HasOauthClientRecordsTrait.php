<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractBase\Behaviours\HasOauthClient;

use ByTIC\Hello\Utility\ModelsHelper;

/**
 * @property $client_id
 */
trait HasOauthClientRecordsTrait
{
    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsHello();
    }

    protected function initRelationsHello()
    {
        $this->initRelationsHelloClient();
    }

    protected function initRelationsHelloClient()
    {
        $this->belongsTo(
            'ClientRecord',
            [
                'class' => get_class(ModelsHelper::clients()),
                'fk' => 'client_id',
            ],
        );
    }
}

