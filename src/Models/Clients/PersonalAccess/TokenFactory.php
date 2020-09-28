<?php

namespace ByTIC\Hello\Models\Clients\PersonalAccess;

use ByTIC\Hello\Models\AccessTokens\Token;
use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Utility\ModelsHelper;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Nip\Container\Container;

/**
 * Class TokenFactory
 * @package ByTIC\Hello\Models\Clients\PersonalAccess
 */
class TokenFactory
{
    /**
     * The authorization server instance.
     *
     * @var \League\OAuth2\Server\AuthorizationServer
     */
    protected $server;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Client
     */
    protected $jwt;

    /**
     * TokenFactory constructor
     *
     * @param \League\OAuth2\Server\AuthorizationServer $server
     * @param $client
     */
    public function __construct(AuthorizationServer $server = null, $client = null, JwtParser $jwt = null)
    {
        $this->server = $server ? $server : Container::getInstance()->get(AuthorizationServer::class);
        $this->client = $client ? $client : ClientsManager::get();
        $this->jwt = $jwt ? $jwt : new JwtParser();
    }


    /**
     * Create a new personal access token.
     *a
     * @param mixed $userId
     * @param string $name
     * @param array $scopes
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function make($userId, $name, array $scopes = [])
    {
        $response = $this->dispatchRequestToAuthorizationServer(
            $this->createRequest($this->client, $userId, $scopes)
        );

        $token = $this->findAccessToken($response);

        return $token;
    }

    /**
     * Create a request instance for the given client.
     *
     * @param Client $client
     * @param mixed $userId
     * @param array $scopes
     * @return Request
     */
    protected function createRequest($client, $userId, array $scopes)
    {
        return (new ServerRequest())->withParsedBody([
            'grant_type' => 'personal_access',
            'client_id' => $client->getIdentifier(),
            'client_secret' => $client->getSecret(),
            'user_id' => $userId,
            'scope' => implode(' ', $scopes),
        ]);
    }

    /**
     * Dispatch the given request to the authorization server.
     *
     * @param Request $request
     * @return array
     */
    protected function dispatchRequestToAuthorizationServer(ServerRequest $request)
    {
        return json_decode(
            $this->server->respondToAccessTokenRequest(
                $request,
                new Response()
            )->getBody()->__toString(),
            true
        );
    }

    /**
     * Get the access token instance for the parsed response.
     *
     * @param array $response
     * @return Token
     */
    protected function findAccessToken(array $response)
    {
        return ModelsHelper::accessTokens()->getByIdentifier(
            $this->jwt->parse($response['access_token'])->getClaim('jti')
        );
    }
}
