<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractToken;

use ByTIC\Hello\Models\AbstractBase\Behaviours\HasOauthClient\HasOauthClientRecordsTrait;
use Nip\Records\RecordManager;

/**
 *
 */
class AbstractTokens extends RecordManager
{
    use HasOauthClientRecordsTrait;
}