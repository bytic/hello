<?php

namespace ByTIC\Hello\Tests\Models\AccessTokens;

use ByTIC\Hello\Models\AccessTokens\Token;
use ByTIC\Hello\Models\AccessTokens\Tokens;
use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Tests\AbstractTest;

/**
 * Class TokensTest
 * @package ByTIC\Hello\Tests\Models\AccessTokens
 */
class TokensTest extends AbstractTest
{
    public function testGetNewToken()
    {
        $manager = new Tokens();
        $manager->setPrimaryKey('id');

        $client = new Client();

        $token = $manager->getNewToken($client, []);
        self::assertInstanceOf(Token::class, $token);
        self::assertSame($client, $token->getClient());
    }
}
