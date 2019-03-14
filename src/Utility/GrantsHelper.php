<?php

namespace ByTIC\Hello\Utility;

/**
 * Class GrantHelper
 * @package ByTIC\Hello\Utility
 */
final class GrantsHelper
{
    /**
     * Grant types support by draft 20
     */
    const GRANT_TYPE_AUTH_CODE = 'authorization_code';
    const GRANT_TYPE_IMPLICIT = 'token';
    const GRANT_TYPE_USER_CREDENTIALS = 'password';
    const GRANT_TYPE_CLIENT_CREDENTIALS = 'client_credentials';
    const GRANT_TYPE_REFRESH_TOKEN = 'refresh_token';
    const GRANT_TYPE_EXTENSIONS = 'extensions';
    /**
     * Regex to filter out the grant type.
     * NB: For extensibility, the grant type can be a URI
     *
     * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.5
     */
    const GRANT_TYPE_REGEXP = '#^(authorization_code|token|password|client_credentials|refresh_token|https?://.+|urn:.+)$#';
}
