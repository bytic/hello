<?php

namespace ByTIC\Hello\Modules\AbstractModule\Controllers\Traits;

/**
 * Trait AbstractAuthenticationControllerTrait
 * @package ByTIC\Hello\Modules\AbstractModule\Controllers\Traits
 */
trait AbstractAuthenticationControllerTrait
{
    use HasAuthenticationVariablesTrait;

    protected function beforeAction()
    {
        parent::beforeAction();
        $this->checkIsAuthenticated();
    }

    protected function afterActionViewVariables()
    {
        parent::afterActionViewVariables();

        $this->setAuthenticationVariablesInView();
    }

    /**
     * @param null $type
     */
    protected function checkIsAuthenticated()
    {
        if ($this->getName() != 'logout' && $this->_getUser()->authenticated()) {
            $this->doSuccessRedirect();
        }
    }

    /**
     * @param null $type
     */
    protected function doSuccessRedirect($type = null)
    {
        $type = empty($type) ? $this->getName() : $type;
        $this->flashRedirect(
            $this->getModelManager()->getMessage($type . '-success'),
            $this->getRedirectURL(),
            'success',
            'index'
        );
    }

    /**
     * @return string
     */
    protected function getRedirectURL()
    {
        $redirectVariable = $this->getAuthenticationValue('redirect');
        if (!empty($redirectVariable)) {
            $url = urldecode($redirectVariable);
            if (valid_url($url)) {
                return $url;
            }
        }
        return $this->getGenericRedirectURL();
    }

    /**
     * @return string|null
     */
    protected function getGenericRedirectURL()
    {
        $module = $this->getRequest()->getModuleName();
        return $this->Url()->assemble($module . '.logged_in');
    }

    /**
     * @param $action
     */
    protected function _setMeta($action)
    {
        $label = $this->getModelManager()->getLabel($action . '-title');
        $urlMethod = 'get' . ucfirst($action) . 'URL';
        $this->getView()->Breadcrumbs()->addItem($label, $this->_getUser()->getManager()->$urlMethod());

        $this->getView()->Meta()->prependTitle($label);
    }


    /**
     * @inheritdoc
     */
    protected function generateModelName()
    {
        return get_class($this->_getUser()->getManager());
    }
}
