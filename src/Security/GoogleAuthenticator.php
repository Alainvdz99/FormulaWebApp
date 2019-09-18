<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class GoogleAuthenticator.
 */
class GoogleAuthenticator extends SocialAuthenticator
{
    /**
     * @var \KnpU\OAuth2ClientBundle\Client\ClientRegistry
     */
    private $clientRegistry;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * GoogleAuthenticator constructor.
     *
     * @param \KnpU\OAuth2ClientBundle\Client\ClientRegistry $clientRegistry
     * @param \Doctrine\ORM\EntityManagerInterface           $entityManager
     * @param \Symfony\Component\Routing\RouterInterface     $router
     */
    public function __construct(
        ClientRegistry $clientRegistry,
        EntityManagerInterface $entityManager,
        RouterInterface $router
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return 'security_google_check' === $request->attributes->get('_route');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \League\OAuth2\Client\Token\AccessToken|mixed
     */
    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getGoogleClient());
    }

    /**
     * @param mixed                                                       $credentials
     * @param \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider
     *
     * @return \App\Entity\User|null|object|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
        $googleUser = $this
            ->getGoogleClient()
            ->fetchUserFromToken($credentials);

        $user = $this
            ->entityManager
            ->getRepository(User::class)
            ->findOneBy(
                [
                    'email' => $googleUser->getEmail(),
                ]
            );

        if ($user) {
            return $user;
        }

        $user = new User();
        $user->setEmail($googleUser->getEmail());
        $user->setFullname($googleUser->getName());
        $user->setAvatar($googleUser->getAvatar());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request                               $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException|null $authException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function start(Request $request, ?AuthenticationException $authException = null): \Symfony\Component\HttpFoundation\Response
    {
        return new RedirectResponse(
            $this->router->generate('security_google_connect'),
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request                          $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     *
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?\Symfony\Component\HttpFoundation\Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request                            $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed                                                                $providerKey
     *
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        $providerKey
    ): ?\Symfony\Component\HttpFoundation\Response {
        return null;
    }

    /**
     * @return \KnpU\OAuth2ClientBundle\Client\OAuth2Client
     */
    private function getGoogleClient(): \KnpU\OAuth2ClientBundle\Client\OAuth2Client
    {
        return $this
            ->clientRegistry
            ->getClient('google');
    }

    /**
     * @return bool
     */
    public function supportsRememberMe(): bool
    {
        return true;
    }
}
