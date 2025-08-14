<?php

namespace ByTIC\Hello\Tests\Models\AccessTokens;

use ByTIC\Hello\Models\AccessTokens\Token;
use ByTIC\Hello\Models\AccessTokens\Tokens;
use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Tests\Fixtures\Models\Users\User;
use Mockery\Mock;
use Nip\Database\Query\Condition\AndCondition;
use Nip\Database\Query\Select;
use Nip\Records\Collections\Collection;

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
        $client->setIdentifier('999');

        $token = $manager->getNewToken($client, [], '3');
        self::assertInstanceOf(Token::class, $token);
        self::assertSame($client, $token->getClient());

        self::assertEquals(
            ['client_id' => '999', 'user_id' => '3'],
            $token->toArray()
        );
    }

    public function testGetValidUserToken()
    {
        $query = new Select();
        /** @var Tokens $manager */
        $manager = \Mockery::mock(Tokens::class)->makePartial();

        $manager->shouldReceive('newQuery')->andReturn($query);
        $manager->shouldReceive('findByQuery')->andReturn(new Collection([new Token()]));

        $client = new Client();
        $client->setIdentifier('999');

        $user = new User();
        $user->setIdentifier('user-1');

        $tokens = $manager->getValidUserTokens($user, $client);

        self::assertInstanceOf(Collection::class, $tokens);

        $where = $query->getPart('where');
        self::assertInstanceOf(AndCondition::class, $where);
    }

    public function test_getQueryModelData()
    {
        $data = [
            'id' => '',
            'identifier' => '',
            'user_id' => 9,
            'client_id' => '',
            'name' => '',
            'scopes' => '',
            'revoked' => '',
            'expires_at' => '',
            'created' => '',
            'updated' => ''
        ];
        /** @var Mock|Tokens $manager */
        $manager = \Mockery::mock(Tokens::class)->makePartial();
        $manager->setFields(array_keys($data));

        $token = new Token();
        $token->user_id = 9;

        self::assertSame($data, $manager->getQueryModelData($token));
    }
}
