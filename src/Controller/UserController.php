<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        $users = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findBy([],
                [
                    'totalPoints' => 'ASC'
                ]

            );

        return $this->render('formula/path/user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
