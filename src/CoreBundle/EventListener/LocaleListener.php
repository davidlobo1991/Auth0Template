<?php

namespace CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListener implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();
        $locale = $this->defaultLocale;

        if(!empty($request->attributes->get('_locale'))) {

            $locale = $request->attributes->get('_locale');
            $session->set('_locale', $locale);

        } else if(!empty($session->get('_locale'))) {

            $locale = $session->get('_locale');

        } else if(!empty($request->cookies->get('_locale'))) {

            $locale = $request->cookies->get('_locale');

        }

        $request->setLocale($locale);

    }

    public function onKernelResponse(FilterResponseEvent $event) {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $session = $request->getSession();

        if(!empty($session->get('_locale')))
            $response->headers->setCookie(new Cookie('_locale', $session->get('_locale')));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                [
                    'onKernelRequest',
                    20
                ]
            ],
            KernelEvents::RESPONSE => [
                [
                    'onKernelResponse',
                    20
                ]
            ]
        ];
    }
}
