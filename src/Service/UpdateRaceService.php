<?php

namespace App\Service;

use App\Entity\Race;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateRaceService extends AbstractController
{
    /**
     * @throws Exception
     */
    public function updateRaces(): void
    {
        $races = $this
            ->getDoctrine()
            ->getRepository(Race::class)
            ->findAll();

        $manager = $this->getDoctrine()->getManager();

        /** @var Race $race */
        foreach ($races as $race)
        {
            $race->setIsActive($race->isAvailable());

            $manager->persist($race);
        }

        $manager->flush();
    }

}