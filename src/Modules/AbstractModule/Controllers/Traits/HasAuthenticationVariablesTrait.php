<?php

namespace ByTIC\Hello\Modules\AbstractModule\Controllers\Traits;

use Nip\Request;
use Nip\View\ViewInterface;

/**
 * Trait HasAuthenticationVariablesTrait
 * @package KM42\Hello\Modules\AbstractModule\Controllers\Traits
 */
trait HasAuthenticationVariablesTrait
{
    protected $authenticationVariable = null;
    protected $authenticationValues = null;

    public function setAuthenticationVariablesInView()
    {
        $this->getView()->set('authenticationVariables', $this->getAuthenticationVariables());
    }

    /**
     * @return array
     */
    protected function getAuthenticationVariables()
    {
        if ($this->authenticationVariable === null) {
            $this->initAuthenticationVariables();
        }

        return $this->authenticationVariable;
    }

    protected function initAuthenticationVariables()
    {
        $this->authenticationVariable = $this->generateAuthenticationVariables();
    }

    /**
     * @return array
     */
    protected function generateAuthenticationVariables()
    {
        $variables = [
            'redirect' => $this->getAuthenticationVarRedirect(),
        ];

        return $variables;
    }

    /**
     * @return string|null
     */
    protected function getAuthenticationVarRedirect()
    {
        if (method_exists($this, 'generateAuthenticationVarRedirect')) {
            $redirect = $this->generateAuthenticationVarRedirect();
        } else {
            $redirect = $this->getRequest()->query->has('redirect')
                ? $this->getRequest()->query->get('redirect')
                : null;
        }
        return $this->isEncodedVariable($redirect) ? $redirect : $this->encodeVariable($redirect);
    }


    /**
     * @return array
     */
    protected function getAuthenticationValues()
    {
        $this->checkInitAuthenticationValues();
        return $this->authenticationValues;
    }

    protected function checkInitAuthenticationValues()
    {
        if ($this->authenticationValues === null) {
            $this->initAuthenticationValues();
        }
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function getAuthenticationValue($key, $default = null)
    {
        $this->checkInitAuthenticationValues();
        return isset($this->authenticationValues[$key]) ? $this->authenticationValues[$key] : $default;
    }

    /**
     * @return array
     */
    protected function initAuthenticationValues()
    {
        return $this->authenticationValues = $this->generateAuthenticationValues();
    }

    /**
     * @return array
     */
    protected function generateAuthenticationValues()
    {
        $variables = $this->getAuthenticationVariables();
        $return = [];
        foreach ($variables as $key => $value) {
            $return[$key] = $this->isEncodedVariable($value) ? $this->decodeVariables($value) : $value;
        }
        return $return;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function decodeVariables($value)
    {
        return base64_decode(strtr($value, '$_-', '+/='));
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function encodeVariable($value)
    {
        return strtr(base64_encode($value), '+/=', '$_-');
    }

    /**
     * @param $data
     * @return bool
     */
    protected function isEncodedVariable($data)
    {
        if ($this->encodeVariable($this->decodeVariables($data)) === $data) {
            return true;
        }
        return false;
    }

    /**
     * @return ViewInterface
     */
    protected abstract function getView();

    /**
     * @return Request
     */
    protected abstract function getRequest();
}
