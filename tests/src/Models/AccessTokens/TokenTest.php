<?php

namespace ByTIC\Hello\Tests\Models\AccessTokens;

use ByTIC\Hello\Models\AccessTokens\Token;
use ByTIC\Hello\Models\AccessTokens\Tokens;
use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Tests\AbstractTest;
use Nip\Collections\Collection;
use Nip\Records\Locator\ModelLocator;

/**
 * Class TokenTest
 * @package ByTIC\Hello\Tests\Models\AccessTokens
 */
class TokenTest extends AbstractTest
{

    public function testSetIdentifier()
    {
        /** @var Clients $tokens */
        $tokens = \Mockery::mock(Tokens::class)->makePartial();
        $tokens->shouldReceive('getFields')->andReturn(['id', 'identifier', 'secret']);
        $tokens->shouldReceive('getPrimaryKey')->andReturn('id');
        $tokens->shouldReceive('getModel')->andReturn(Token::class);

        $token = $tokens->getNew();
        self::assertNull($token->getIdentifier());

        $token->setIdentifier(99);
        self::assertSame(99, $token->getIdentifier());

        $data = $tokens->getQueryModelData($token);
        self::assertArrayHasKey('identifier', $data);
    }

    public function testGetClient()
    {
        /** @var Tokens $tokens */
        $tokens = \Mockery::mock(Tokens::class)->makePartial();
        $tokens->shouldReceive('getPrimaryKey')->andReturn('id');
        $tokens->shouldReceive('getModel')->andReturn(Token::class);

        $clients = \Mockery::mock(Clients::class)->makePartial();
        $clients->shouldReceive('findByField')->withArgs([
            'identifier',
            '999999'
        ])->andReturn(new Collection([new Client()]));
        ModelLocator::set(Clients::class, $clients);

        $token = $tokens->getNew();
        $token->client_id = '999999';

        $client = $token->getClient();
        self::assertInstanceOf(Client::class, $client);
    }

    public function testGetUserIdentifierFromData()
    {
        $token = new Token();
        $token->writeData(['user_id' => 99]);

        self::assertEquals(99, $token->getUserIdentifier());
    }
}
