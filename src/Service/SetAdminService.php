<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SetAdminService extends AbstractController
{
    public function setAdminRole()
    {


        $user = $this->getAdminUser();

        $user->setRoles(['ROLE_ADMIN']);

        $em = $this
            ->getDoctrine()
            ->getManager();

        $em->persist($user);
        $em->flush();
    }

    public function getAdminUser()
    {
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find(3);

        if (!$user)
        {
            $this->createNotFoundException(
                'Couldnt find an available race'
            );
        }

        return $user;
    }
}