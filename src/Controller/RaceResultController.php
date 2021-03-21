<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\RacePrediction;
use App\Entity\RaceResult;
use App\Form\RaceResultType;
use App\Service\RacePoints;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class RaceResultController extends AbstractController
{
    /**
     * @Route("/race/{raceId}/raceresult/create", name="race_result_create")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request, int $raceId)
    {
        $raceResult = new RaceResult();
        $racePoints = new RacePoints();

        $race = $this->getRace($raceId);

        /** @var \App\Repository\RacePredictionRepository $racePredictions */
        $racePredictions = $this
            ->getDoctrine()
            ->getRepository(RacePrediction::class)
            ->findAllByRace($race);

        $form = $this->createForm(
            RaceResultType::class,
            $raceResult
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager = $this
                ->getDoctrine()
                ->getManager();

            $raceResult->setRace($this->getRace($race->getId()));
            $raceResult->setIsEnabled(false);

            $manager->persist($raceResult);

            foreach ($racePredictions as $racePrediction) {
                $predictonPoints = $racePoints->checkRacePredictionResults($raceResult, $racePrediction);
                $user = $racePrediction->getUser();
                $totalPoints = $user->getTotalPoints();

                $newTotalPoints = $totalPoints + $predictonPoints;
                $user->setTotalPoints($newTotalPoints);

                $manager->persist($user);
            }

            try {
                $manager->flush();
                return $this->redirect(
                    $this->generateUrl('race')
                );

            } catch (BadRequestHttpException $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to create race result (Error: %s)',
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->render(
            'formula/path/race/racePrediction/create.html.twig', [
                'form' => $form->createView(),
                'raceResult' => $raceResult,
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