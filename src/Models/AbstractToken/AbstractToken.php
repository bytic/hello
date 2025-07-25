<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractToken;

use ByTIC\Hello\Models\AbstractBase\Behaviours\HasExpireDate\HasExpireDateRecordTrait;
use ByTIC\Hello\Models\AbstractBase\Behaviours\HasOauthClient\HasOauthClientRecordTrait;
use ByTIC\Hello\Models\AbstractBase\Behaviours\HasOauthUser\HasOauthUserRecordTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 *
 */
class AbstractToken extends \Nip\Records\Record
{
    use TokenEntityTrait, HasOauthClientRecordTrait, HasOauthUserRecordTrait {
        HasOauthUserRecordTrait::setUserIdentifier insteadof TokenEntityTrait;

        HasOauthClientRecordTrait::setClient insteadof TokenEntityTrait;
        HasOauthClientRecordTrait::getClient insteadof TokenEntityTrait;
    }
    use HasExpireDateRecordTrait;
}