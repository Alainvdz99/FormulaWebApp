<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\RacePrediction;
use App\Entity\RaceResult;
use App\Form\RaceType;
use App\Interfaces\CrudControllerInterface;
use App\Repository\RacePredictionRepository;
use App\Repository\RaceRepository;
use App\Repository\RaceResultRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController implements CrudControllerInterface
{
    /**
     * @Route("/race", name="race")
     * @return Response
     * @throws NonUniqueResultException
     */
    public function index()
    {
        /** @var RaceRepository $raceRepository */
        $raceRepository = $this->getDoctrine()->getRepository(Race::class);
        /** @var RaceResultRepository $raceResultRepository */
        $raceResultRepository = $this->getDoctrine()->getRepository(RaceResult::class);
        /** @var RacePredictionRepository $racePredictionRepository */
        $racePredictionRepository = $this->getDoctrine()->getRepository(RacePrediction::class);

        $races = $raceRepository->findBy([],
                [
                    'raceDateStart' => 'ASC'
                ]
            );

        $raceResult = null;
        $racePrediction = null;
        $availableRace = $raceRepository->findAvailableRace();

        if ($availableRace !== null) {
            $raceResult = $raceResultRepository->checkIfRaceResultExist($availableRace->getId());
            $racePrediction = $racePredictionRepository
                ->checkIfRacePredictionExist($availableRace->getId(), $this->getUser()->getId());
        }

        return $this->render('formula/path/race/index.html.twig', [
            'races' => $races,
            'raceResult' => $raceResult,
            'racePrediction' => $racePrediction
        ]);
    }

    /**
     * @Route("/race/create", name="create_race")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $race = new Race();

        $form = $this->createForm(
            RaceType::class,
            $race
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager = $this
                ->getDoctrine()
                ->getManager();

            $race->setIsActive($race->isAvailable());
            $manager->persist($race);

            try {

                $manager->flush();
                return $this->redirect(
                    $this->generateUrl('race')
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
            'formula/path/race/create.html.twig', [
                'form' => $form->createView(),
                'race' => $race
            ]
        );
    }

    /**
     * @Route("/race/delete/{id}")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)
    {
        $race = $this->getRace($id);

        try {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($race);

            $manager->flush();
        } catch(\Throwable $e) {
            $this->addFlash(
                'error',
                sprintf(
                    'Could delete race with id: %s',
                    $id
                )
            );
        }

        return $this->redirect(
            $this->generateUrl('race')
        );
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

        if (!$race) {
            throw $this->createNotFoundException(
                sprintf("Could find race with id: %s",
                    $id)
            );
        }

        return $race;
    }

}
