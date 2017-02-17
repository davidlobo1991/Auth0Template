<?php
namespace TrenkwalderBundle\Controller\User\Profile;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use TrenkwalderBundle\Entity\User;

class ContactDataController extends AbstractController {

    public function indexAction() {

        $user = $this->getUser();
        $form = $this->getForm($user);

        return $this->render('@Trenkwalder/user/profile/contact-data/index.html.twig', ['form' => $form->createView()]);
    }

    public function updateAction(Request $request) {

        $user = $this->getUser();
        $form = $this->getForm($user);
        $status = 400;
        $message = $this->translate('an.error.has.occurred');

        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(['message' => $message], $status);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->persist($user);
            $this->flush();
            $status = 200;
            $message = $this->translate('data.has.been.saved');
        }

        $response = new JsonResponse([
            'message' => $message,
            'form' => $this->renderView('@Trenkwalder/partials/form.html.twig', ['form' => $form->createView()])
        ], $status);

        return $response;
    }

    private function getForm(User $user) {
        $formBuilder = $this->createFormBuilder($user)
            ->setAction($this->generateUrl('user_profile_contact_data_update'))
            ->add('save', SubmitType::class, ['label' => 'save']);

        return $formBuilder->getForm();
    }

}
