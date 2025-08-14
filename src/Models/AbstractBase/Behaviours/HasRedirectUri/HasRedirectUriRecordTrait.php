<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractBase\Behaviours\HasRedirectUri;

/**
 * @property string|string[] $redirect_uri
 */
trait HasRedirectUriRecordTrait
{
    /**
     * Return the registered redirect URI(s).
     * If multiple URIs are stored as a delimited string or JSON, this returns an array as supported by league/oauth2-server.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        $raw = $this->getPropertyRaw('redirect_uri');
        if ($raw === null) {
            return '';
        }
        if (\is_array($raw)) {
            return $this->normalizeRedirectUrisArray($raw);
        }
        $raw = (string) $raw;
        $rawTrim = trim($raw);
        if ($rawTrim === '') {
            return '';
        }
        // Try JSON array first
        $decoded = json_decode($rawTrim, true);
        if (\is_array($decoded)) {
            $uris = $this->normalizeRedirectUrisArray($decoded);
            return count($uris) <= 1 ? ($uris[0] ?? '') : $uris;
        }
        // Fallback: split by comma or whitespace/newlines
        $parts = preg_split('/[\s,]+/', $rawTrim) ?: [];
        $uris = $this->normalizeRedirectUrisArray($parts);
        return count($uris) <= 1 ? ($uris[0] ?? '') : $uris;
    }

    /**
     * @param string|string[] $redirect
     * @return self
     */
    public function setRedirectUri($redirect)
    {
        // Persist as a comma-separated string for backward compatibility
        if (\is_array($redirect)) {
            $redirect = implode(',', $this->normalizeRedirectUrisArray($redirect));
        }
        $this->setPropertyValue('redirect_uri', $redirect);
        // Also keep the in-memory entity property consistent (league's ClientTrait uses $redirectUri)
        $this->redirectUri = $this->getRedirectUri();
        return $this;
    }

    /**
     * Normalize and sanitize a list of URIs: trim, remove empties, unique, preserve order.
     *
     * @param array $uris
     * @return array
     */
    protected function normalizeRedirectUrisArray(array $uris): array
    {
        $clean = [];
        foreach ($uris as $u) {
            if (!\is_string($u)) {
                continue;
            }
            $t = trim($u);
            if ($t === '') {
                continue;
            }
            $clean[] = $t;
        }
        // unique while preserving order
        $unique = [];
        foreach ($clean as $u) {
            if (!in_array($u, $unique, true)) {
                $unique[] = $u;
            }
        }
        return $unique;
    }
}