<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\RacePrediction;
use App\Form\RacePredictionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RacePredictionController extends AbstractController
{
    /**
     * @Route("/race/{raceId}/raceprediction/create", name="race_prediction_create")
     * @param Request $request
     * @param int $raceId
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request, int $raceId)
    {
        $racePrediction = new RacePrediction();

        $race = $this->getRace($raceId);

        $form = $this->createForm(
            RacePredictionType::class,
            $racePrediction
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager = $this
                ->getDoctrine()
                ->getManager();

            $racePrediction->setUser($this->getUser());
            $racePrediction->setRace($this->getRace($race->getId()));
            $racePrediction->setIsActive($race->isAvailable());
            $racePrediction->setIsEnabled(false);

            $manager->persist($racePrediction);

            try {
                $manager->flush();
                return $this->redirect(
                    $this->generateUrl('race')
                );

            } catch (\Throwable $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to create race prediction (Error: %s)',
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->render(
            'formula/path/race/racePrediction/create.html.twig', [
                'form' => $form->createView(),
                'racePrediction' => $racePrediction,
                'raceId' => $race
            ]
        );
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param int $id
     * @return \App\Entity\Race|object|null
     */
    protected function getRace(int $id)
    {
        $race = $this
            ->getDoctrine()
            ->getRepository(Race::class)
            ->find($id);

        if(!$race)
        {
            throw $this->createNotFoundException(
                sprintf("Could find race with id: %s",
                    $id)
            );
        }

        return $race;
    }
}