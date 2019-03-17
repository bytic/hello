<?php

use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Grant\ImplicitGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

return [
    /*
    |--------------------------------------------------------------------------
    | Key path.
    |--------------------------------------------------------------------------
    |
    | Path to the directory where the public and private keys used by the
    | oauth service are.
    |
    */
    'encryption_key' => env('OAUTH_AUTHORIZATION_KEY', ''),
    'key_path' => env('OAUTH_KEYS_PATH', storage_path('oauth')),

    /*
    |--------------------------------------------------------------------------
    | Repositories.
    |--------------------------------------------------------------------------
    |
    | Override the repositories that the models are fetched from.
    | The default implementations uses the $entityManager->getRepository(entity)
    | methods to fetch the given objects.
    |
    | Implementations must implement the interfaces they bind to.
    |
    */
    'repositories' => [
        AccessTokenRepositoryInterface::class => null,
        ClientRepositoryInterface::class => null,
        RefreshTokenRepositoryInterface::class => null,
        ScopeRepositoryInterface::class => null,
        AuthCodeRepositoryInterface::class => null,
        UserRepositoryInterface::class => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Grant types.
    |--------------------------------------------------------------------------
    |
    | Grant types available to use.
    | If one is not wanted, just comment it out and it will not be loaded
    | in to the auth server.
    |
    */
    'grant_types' => [
        'AuthCode' => AuthCodeGrant::class,
        'RefreshToken' => RefreshTokenGrant::class,
        'Password' => PasswordGrant::class,
        'Implicit' => ImplicitGrant::class,
        'ClientCredentials' => ClientCredentialsGrant::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Token lifetime.
    |--------------------------------------------------------------------------
    |
    | Lifetime of the auth tokens.
    | Change to preferred lifetime.
    |
    */
    'token_ttl' => Carbon\CarbonInterval::create(0, 0, 0, 0, 1, 0, 0),

    /*
    |--------------------------------------------------------------------------
    | User identification key.
    |--------------------------------------------------------------------------
    |
    | Key to use when fetching an existing user from the user repository.
    | The user_identification will be the key of the entity that the repository
    | searches for. Could be an email, username, identifier or anything.
    |
    */
    'user_identification' => env('OAUTH_IDENTIFICATION', 'userName'),

    /*
    |--------------------------------------------------------------------------
    | Password hash.
    |--------------------------------------------------------------------------
    |
    | Hash implementation to use when verifying passwords.
    |
    */
//    'password_hash' => Illuminate\Hashing\BcryptHasher::class,

    /*
    |--------------------------------------------------------------------------
    | Scope validator.
    |--------------------------------------------------------------------------
    |
    | Class which validates the scopes on auth requests.
    | If you do not use scopes, default implementation can be used, else
    | implement your own and bind it here.
    |
    */
//    Jitesoft\Loauthd\Contracts\ScopeValidatorInterface::class => Jitesoft\Loauthd\ScopeValidator::class,

    /*
    |--------------------------------------------------------------------------
    | User class.
    |--------------------------------------------------------------------------
    |
    | If you use another user class than the default provided by framework
    | it can be changed here.
    |
    */
//    'user_model' => Jitesoft\Loauthd\Entities\User::class,
];
