<?php

namespace ByTIC\Hello\Tests\Models\Clients;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Tests\AbstractTest;

class ClientRedirectUriTest extends AbstractTest
{
    public function testSingleRedirectUriBehavior()
    {
        $client = new Client();
        $client->setRedirectUri('https://example.com/callback');
        $value = $client->getRedirectUri();
        self::assertIsString($value);
        self::assertSame('https://example.com/callback', $value);
    }

    public function testMultipleRedirectUrisArray()
    {
        $client = new Client();
        $client->setRedirectUri([
            'https://example.com/callback',
            ' https://app.example.com/return ',
            'https://example.com/callback', // duplicate
            '',
        ]);
        $value = $client->getRedirectUri();
        self::assertIsArray($value);
        self::assertSame([
            'https://example.com/callback',
            'https://app.example.com/return',
        ], $value);
    }

    public function testMultipleRedirectUrisDelimitedString()
    {
        $client = new Client();
        // simulate persisted CSV/newline formats
        $client->setDataValue('redirect_uri', 'https://a.test/cb, https://b.test/cb  https://c.test/cb');
        $value = $client->getRedirectUri();
        self::assertIsArray($value);
        self::assertSame([
            'https://a.test/cb',
            'https://b.test/cb',
            'https://c.test/cb',
        ], $value);

        $client2 = new Client();
        $client2->setDataValue('redirect_uri', "[\"https:\\/\\/a.test\\/cb\", \"https:\\/\\/b.test\\/cb\"]");
        $value2 = $client2->getRedirectUri();
        self::assertIsArray($value2);
        self::assertSame([
            'https://a.test/cb',
            'https://b.test/cb',
        ], $value2);
    }
}
