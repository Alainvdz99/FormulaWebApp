<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserToken;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends BaseController
{

    public function registerAction(Request $request)
    {
        $token = $request->query->get('token');
        if ($token === null) {
            return $this->redirect(
                $this->generateUrl('fos_user_security_login')
            );
        }

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        /** @var UserToken $userToken */
        $userToken = $this
            ->getDoctrine()
            ->getRepository(UserToken::class)
            ->findOneBy([
                'token' => $token
            ]);

        if ($userToken === null) {
            return $this->redirect(
                $this->generateUrl('fos_user_security_login')
            );
        }

        if ($userRepository->findOneBy(['email' => $userToken->getEmail()]) !== null) {
            return $this->redirect(
                $this->generateUrl('fos_user_security_login')
            );
        }

        $request->request->set('token', $userToken->getToken());
        $request->request->set('email', $userToken->getEmail());

        return parent::registerAction($request);
    }


}
