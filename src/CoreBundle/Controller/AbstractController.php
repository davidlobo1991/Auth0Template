<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbstractController extends Controller {

    public function translate(string $key, array $parameters = [], string $domain = null, string $locale = null) {
        return $this->get('core.localization_service')->translate($key, $parameters, $domain, $locale);
    }

    public function persist($object) {
        $this->getDoctrine()->getManager()->persist($object);
    }

    public function flush() {
        $this->getDoctrine()->getManager()->flush();
    }

    public function __get($name)
    {
        switch($name) {
            case 'session':
                return $this->container->get('session');
            default:
                throw new \Exception('Variable not exists: ' . $name);
        }
    }

}
