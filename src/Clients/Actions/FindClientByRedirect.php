<?php

declare(strict_types=1);

namespace ByTIC\Hello\Clients\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\FindRecords;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use ByTIC\Hello\Utility\ModelsHelper;
use Nip\Records\AbstractModels\RecordManager;

/**
 *
 */
class FindClientByRedirect extends Action
{
    use HasSubject;
    use FindRecords;

    protected function findParams(): array
    {
        return [
            'where' => [
                ['`redirect_uri` LIKE ?', '%'.$this->getSubject().'%']
            ]
        ];
    }

    protected function generateRepository(): RecordManager
    {
        return ModelsHelper::clients();
    }
}
