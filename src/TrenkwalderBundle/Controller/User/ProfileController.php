<?php
namespace TrenkwalderBundle\Controller\User;

use CoreBundle\Controller\AbstractController;

class ProfileController extends AbstractController {

    public function indexAction() {
        return $this->render('@Trenkwalder/user/profile/index.html.twig');
    }

}

