<?php

namespace ByTIC\Hello\Tests\Models\AccessTokens;

use ByTIC\Hello\Models\AccessTokens\Token;
use ByTIC\Hello\Models\AccessTokens\Tokens;
use ByTIC\Hello\Tests\AbstractTest;

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

        $client = $tokens->getNew();
        self::assertNull($client->getIdentifier());

        $client->setIdentifier(99);
        self::assertSame(99, $client->getIdentifier());

        $data = $tokens->getQueryModelData($client);
        self::assertArrayHasKey('identifier', $data);
    }
}
