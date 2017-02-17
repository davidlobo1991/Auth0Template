<?php
namespace TrenkwalderBundle\Controller\User\Profile;

use CoreBundle\Controller\AbstractController;

class ResumeController extends AbstractController {

    public function indexAction() {
        return $this->render('@Trenkwalder/user/profile/resume/index.html.twig');
    }

}
