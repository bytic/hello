<?php

declare(strict_types=1);

namespace ByTIC\Hello\Clients\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\FindRecord;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use ByTIC\Hello\Utility\ModelsHelper;
use Nip\Records\AbstractModels\RecordManager;

/**
 *
 */
class FindClientByRedirect extends Action
{
    use HasSubject;
    use FindRecord;

    protected function findParams(): array
    {
        return [
            ['where' => ["`redirect_uri` LIKE '%?%", $this->getSubject()]],
        ];
    }

    protected function generateRepository(): RecordManager
    {
        return ModelsHelper::clients();
    }
}
