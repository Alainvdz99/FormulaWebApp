<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserToken;
use App\Form\UserTokenType;
use Ramsey\Uuid\Uuid;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserController extends AbstractController
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/standings", name="standings")
     */
    public function indexStandings()
    {
        $users = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findBy([],
                [
                    'totalPoints' => 'DESC'
                ]

            );

        return $this->render('formula/path/user/standings/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/users", name="users")
     */
    public function index()
    {
        $users = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findBy([],
                [
                    'totalPoints' => 'DESC'
                ]
            );

        return $this->render('formula/path/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/create", name="admin_user_create")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $userToken = new UserToken();

        $form = $this->createForm(
            UserTokenType::class,
            $userToken
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager = $this
                ->getDoctrine()
                ->getManager();

            $userToken->setToken(Uuid::uuid4());
            $manager->persist($userToken);

            try {
                $url = $this->generateUrl('register_with_token', ['token' => $userToken->getToken()]);
                $message = (new Swift_Message())
                    ->setSubject('Maak je Formule 1 account aan!')
                    ->setFrom('test@test.nl')
                    ->setTo($userToken->getEmail())
                    ->setBody($this->renderView(
                        'formula/mail/user/create.html.twig',
                        [
                            'url' => $url,
                            'email' => $userToken->getEmail()
                        ]
                    ));

                $this->mailer->send($message);
                $manager->flush();

                return $this->redirect(
                    $this->generateUrl('user')
                );

            } catch (\Throwable $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to create race (Error: %s)',
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->render(
            'formula/path/user/create.html.twig', [
                'form' => $form->createView(),
                'userToken' => $userToken
            ]
        );
    }
}
