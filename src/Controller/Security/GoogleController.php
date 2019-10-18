<?php

declare(strict_types=1);

namespace App\Controller\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    /**
     * @Route("/logout", name="logout")
     * @throws \Exception
     */
    public function logout()
    {
        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/security/google", name="security_google")
     */
    public function index(): Response
    {
        return $this->render('security/google/index.html.twig', [
            'controller_name' => 'GoogleController',
        ]);
    }

    /**
     * @Route("/security/google/connect", name="security_google_connect")
     *
     * @param \KnpU\OAuth2ClientBundle\Client\ClientRegistry $clientRegistry
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connect(ClientRegistry $clientRegistry): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect([
                'email',
                'profile',
            ]);
    }

    /**
     * @Route("/security/google/check", name="security_google_check")
     */
    public function connectCheck(Request $request, ClientRegistry $clientRegistry): RedirectResponse
    {
        return $this->redirect($this->generateUrl('home'));
    }
}
