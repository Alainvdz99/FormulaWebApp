<?php

namespace App\Service;

use App\Entity\Race;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateRaceService extends AbstractController
{
    public function updateRaces()
    {
        $races = $this
            ->getDoctrine()
            ->getRepository(Race::class)
            ->findAll();

        $manager = $this->getDoctrine()->getManager();

        foreach ($races as $race)
        {
            $race->setIsActive($race->isAvailable());

            $manager->persist($race);
        }

        $manager->flush();
    }

}