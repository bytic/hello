<?php

declare(strict_types=1);

use ByTIC\GoogleRecaptcha\Utility\GoogleRecaptcha;
use Nip\Form\Elements\AbstractElement;

/**
 * Class Nip_Form_Element_PersonalBest.
 *
 * @property Nip_Form_Element_Abstract[] $_elements
 * @method Nip_Form_Element_Abstract[] getElements
 */
class Nip_Form_Element_Recaptcha extends AbstractElement
{
    protected $_type = 'recaptcha';

    protected \ByTIC\GoogleRecaptcha\RecaptchaManager|null $manager = null;

    public function init()
    {
        parent::init();
        $this->manager = GoogleRecaptcha::getManager();
    }

    public function validate()
    {
        parent::validate();
        if ($this->isError()) {
            return;
        }
        $value = $this->getValue();
        $this->validateRecaptcha($value);
    }

    public function getSiteKey()
    {
        return $this->manager->getSiteKey();
    }

    public function getOption($key, $default = null)
    {
        if ($key == 'siteKey') {
            return $this->getSiteKey();
        }
        if ($key == 'render_label') {
            return false;
        }
        return parent::getOption($key, $default);
    }

    protected function validateRecaptcha(string $string): void
    {
        $response = $this->manager->verify($string);
        if ($response->isSuccess()) {
            return;
        }
        $errors = $response->getErrorCodes();
        $this->addError('Recaptcha error: ' . implode(', ', $errors));
    }
}
