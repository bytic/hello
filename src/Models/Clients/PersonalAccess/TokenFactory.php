<?php

namespace ByTIC\Hello\Models\Clients\PersonalAccess;

use ByTIC\Hello\Models\Clients\Client;
use League\OAuth2\Server\AuthorizationServer;
use Nip\Container\Container;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;

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
     * TokenFactory constructor
     *
     * @param \League\OAuth2\Server\AuthorizationServer $server
     * @param $client
     */
    public function __construct(AuthorizationServer $server = null, $client = null)
    {
        $this->server = $server ? $server : Container::getInstance()->get(AuthorizationServer::class);
        $this->client = $client ? $client : ClientsManager::get();

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

//        $token = tap($this->findAccessToken($response), function ($token) use ($userId, $name) {
//            $this->tokens->save($token->forceFill([
//                'user_id' => $userId,
//                'name' => $name,
//            ]));
//        });

        return $response;
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
                $request, new Response
            )->getBody()->__toString(),
            true
        );
    }
}