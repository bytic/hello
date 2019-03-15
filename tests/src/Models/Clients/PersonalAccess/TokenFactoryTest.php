<?php

namespace ByTIC\Hello\Tests\Models\Clients\PersonalAccess;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Models\Clients\PersonalAccess\TokenFactory;
use ByTIC\Hello\Tests\AbstractTest;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use Mockery as m;

/**
 * Class TokenFactoryTest
 * @package ByTIC\Hello\Tests\Models\Clients\PersonalAccess
 */
class TokenFactoryTest extends AbstractTest
{
    public function testMake()
    {
        $server = m::mock(AuthorizationServer::class)->makePartial();
        $server->shouldReceive('respondToAccessTokenRequest')->andReturn($response = m::mock());
        $response->shouldReceive('getBody->__toString')->andReturn(json_encode([
            'access_token' => 'foo',
        ]));

        $client = new Client();

        $factory = new TokenFactory($server, $client);

        $result = $factory->make(1, 'token', ['scopes']);
//        $this->assertInstanceOf(PersonalAccessTokenResult::class, $result);
    }
}
