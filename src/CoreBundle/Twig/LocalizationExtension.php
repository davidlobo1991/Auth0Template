<?php

namespace CoreBundle\Twig;

use CoreBundle\Service\LocalizationService;
use Symfony\Component\Translation\DataCollectorTranslator;

class LocalizationExtension extends \Twig_Extension {

    private $localizationService;

    public function __construct(LocalizationService $localizationService) {
        $this->localizationService = $localizationService;
    }

    public function getFunctions() {
        return [
            new \Twig_Function('translate', [$this->localizationService, 'translate'])
        ];
    }
}
