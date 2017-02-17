<?php
namespace TrenkwalderBundle\Controller;

use CoreBundle\Controller\AbstractController;

class IndexController extends AbstractController {

    public function indexAction() {

        if($this->isGranted('ROLE_ADMIN')) return $this->redirectToRoute('/admin');
        if($this->isGranted('ROLE_USER')) return $this->redirectToRoute('user_profile');

        return $this->render('TrenkwalderBundle:index:index.html.twig');
    }

    public function noAccessAction() {
        $this->addFlash(
            'error',
            'Please login.'
        );

        return $this->redirectToRoute('index');
    }

    public function dataPrivacyAction() {
        return $this->render('TrenkwalderBundle:index:data-privacy.html.twig');
    }
}
