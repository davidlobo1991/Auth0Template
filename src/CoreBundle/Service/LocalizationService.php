<?php

namespace CoreBundle\Service;

use Symfony\Component\Translation\DataCollectorTranslator;

class LocalizationService {

    private $translator;

    public function __construct(DataCollectorTranslator $translator) {
        $this->translator = $translator;
    }

    public function translate(string $key, array $parameters = [], string $domain = null, string $locale = null) {
        return $this->translator->trans($key, $parameters, $domain, $locale);
    }
}
