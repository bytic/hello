<?php

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

use Nip\Controllers\Traits\AbstractControllerTrait;
use Nip\Records\Locator\ModelLocator;

/**
 * Trait LoginControllerTrait
 * @package ByTIC\Hello\Modules\Frontend\Controllers\Traits
 */
trait LoginControllerTrait
{
    use AbstractControllerTrait;

    public function index()
    {
        $usersManager = $this->getModelManager();
        $this->getView()->set('headerTitle', $usersManager->getLabel('login-title'));

        $loginForm = $this->_getUser()->getForm('login');

        if ($loginForm->submited()) {
            if ($loginForm->processRequest()) {
                $this->doSuccessRedirect();
            }
        } else {
            if ($this->getRequest()->query->has('message')) {
                $loginForm->addMessage($this->getRequest()->query->get('message'), 'info');
            }
        }

        $this->forms['login'] = $loginForm;
        $this->getView()->set('redirect', $this->getRedirectURL());
        $this->_setMeta('login');

        $this->getView()->Breadcrumbs()->addItem(
            $this->getModelManager()->getLabel('login-title'),
            $this->_getUser()->getManager()->compileURL('login')
        );
        $this->getView()->Meta()->prependTitle($this->getModelManager()->getLabel('login-title'));
    }

    /**
     * @inheritdoc
     */
    protected function generateModelName()
    {
        return get_class($this->_getUser()->getManager());
    }
}
