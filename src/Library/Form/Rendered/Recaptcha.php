<?php

declare(strict_types=1);

use Nip\Form\Renderer\Elements\AbstractElementRenderer;

/**
 * @method Nip_Form_Element_Recaptcha getElement()
 */
class Nip_Form_Renderer_Elements_Recaptcha extends AbstractElementRenderer
{
    public function generateElement()
    {
        $return = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        $return .= '<div class="g-recaptcha" data-sitekey="' . $this->getElement()->getSiteKey() . '"></div>';
        return $return;
    }
}
