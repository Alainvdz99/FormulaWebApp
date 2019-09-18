<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\RaceResult;
use App\Form\RaceResultType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RaceResultController extends AbstractController
{
    /**
     * @Route("/race/{raceId}/raceresult/create", name="race_prediction_create")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request, int $raceId)
    {
        $raceResult = new RaceResult();

        $race = $this->getRace($raceId);

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

            try {
                $manager->flush();
                return $this->redirect(
                    $this->generateUrl('race')
                );

            } catch (\Throwable $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to create race resukt (Error: %s)',
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->render(
            'formula/path/driver/create.html.twig', [
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