<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\SpecialPrediction;
use App\Entity\SpecialPredictionInput;
use App\Entity\SpecialPredictionResult;
use App\Entity\SpecialPredictionVote;
use App\Form\SpecialPredictionInputResultType;
use App\Form\SpecialPredictionInputType;
use App\Form\SpecialPredictionType;
use App\Service\ErrorHandling;
use App\Service\RacePoints;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidatorException;

class SpecialPredictionController extends AbstractController
{
    /**
     * @var \App\Service\ErrorHandling
     */
    private $errorHandling;

    public function __construct(ErrorHandling $errorHandling)
    {
        $this->errorHandling = $errorHandling;
    }

    /**
     * @Route("/special-prediction", name="special_prediction")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        /** @var SpecialPrediction[] $specialPredictions */
        $specialPredictions = $this
            ->getDoctrine()
            ->getRepository(SpecialPrediction::class)
            ->findSpecialPredictionsByAvailableRace();

        /** @var SpecialPredictionVote[] $specialPredictionVotes */
        $specialPredictionVotes =  $this
            ->getDoctrine()
            ->getRepository(SpecialPredictionVote::class)
            ->findBy([
                'user' => $this->getUser(),
                'race' => $this->getAvailableRace()
            ]);

        $race = $this->getAvailableRace();
        $specialPredictionInput = new SpecialPredictionInput();

        foreach ($specialPredictions as $specialPrediction)
        {
            foreach ($specialPredictionVotes as $predictionVote) {
                if ($specialPrediction->getId() === $predictionVote->getSpecialPrediction()->getId()) {
                    $specialPredictionInput->addSpecialPredictionVote($predictionVote);
                    continue 2;
                }
            }
            $specialPredictionVote = new SpecialPredictionVote();

            $specialPredictionVote->setSpecialPrediction($specialPrediction);
            $specialPredictionVote->setUser($this->getUser());
            $specialPredictionVote->setRace($race);

            $specialPredictionInput->addSpecialPredictionVote($specialPredictionVote);

        }

        $specialPredictionInputForm = $this
            ->createForm(SpecialPredictionInputType::class,
                $specialPredictionInput);

        $specialPredictionInputForm->handleRequest($request);

        if ($specialPredictionInputForm->isSubmitted() && $specialPredictionInputForm->isValid())
        {
            $manager = $this->getDoctrine()->getManager();

            foreach ($specialPredictionInput->getSpecialPredictionVotes() as $predictionVote)
            {
                $manager->persist($predictionVote);
            }

            try {
                $manager->flush();
                return $this->redirect(
                    $this->generateUrl('special_prediction')
                );

            } catch (BadRequestHttpException $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to save: (Error: %s)',
                        $e->getMessage()
                    )
                );
            }

        }

            return $this->render('formula/path/specialPrediction/index.html.twig', [
            'race' => $race,
            'form' => $specialPredictionInputForm->createView(),
        ]);
    }

    /**
     * @Route("/special-prediction/create", name="special_prediction_create")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        try {
            $specialPrediction = new SpecialPrediction();

            $form = $this->createForm(SpecialPredictionType::class, $specialPrediction);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                $specialPrediction->setRace($this->getAvailableRace());
                $specialPrediction->setCreatedBy($this->getUser());

                $manager->persist($specialPrediction);

                try {
                    $manager->flush();

                    return $this->redirect(
                        $this->generateUrl('special_prediction')
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

            if ($form->isSubmitted() && !$form->isValid()) {
                $this->errorHandling->handleFormErrors($form);
            }

            return $this->render(
                'formula/path/specialPrediction/create.html.twig',
                [
                    'form'              => $form->createView(),
                    'SpecialPrediction' => $specialPrediction,
                ]
            );
        } catch (UniqueConstraintViolationException $exception) {
            return new JsonResponse(
                [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'userMessage' => "Er bestaal al een voorspelling met dit account"
                ],
                Response::HTTP_BAD_REQUEST
            );

        }
        catch (\Throwable $exception) {
            return new JsonResponse(
                [
                    'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @Route("/admin/special-prediction", name="special_prediction_admin")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminIndex(Request $request)
    {
        $specialPredictions = $this
            ->getDoctrine()
            ->getRepository(SpecialPrediction::class)
            ->findSpecialPredictionsByAvailableRace();

        $race = $this->getAvailableRace();

        $form = $this->handleResultForm($specialPredictions, $request);

        return $this->render(
            'formula/path/specialPrediction/adminIndex.html.twig',
            [
                'form' => $form->createView(),
                'race' => $race

            ]
        );
    }

    /**
     * @param array                                     $specialPredictions
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    private function handleResultForm(array $specialPredictions, Request $request)
    {
        $race = $this->getAvailableRace();

        $specialPredictionResults = $this
            ->getDoctrine()
            ->getRepository(SpecialPredictionResult::class)
            ->findByAvailableRace($race);

        $racePointsService = new RacePoints();

        $specialPredictionInputResult = new SpecialPredictionInput();

        if(!$specialPredictionResults)
        {
            foreach ($specialPredictions as $specialPrediction)
            {
                $specialPredictionResult = new SpecialPredictionResult();

                $specialPredictionResult->setSpecialPrediction($specialPrediction);
                $specialPredictionInputResult->addSpecialPredictionResult($specialPredictionResult);
            }
        } else
        {
            foreach ($specialPredictionResults as $specialPredictionResult)
            {
                $specialPredictionInputResult->addSpecialPredictionResult($specialPredictionResult);

            }
        }

        $form = $this
            ->createForm(
                SpecialPredictionInputResultType::class,
                $specialPredictionInputResult);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();

            foreach ($specialPredictionInputResult->getSpecialPredictionResults() as $predictionResult)
            {
                $manager->persist($predictionResult);

                $specialPredictionVotes = $this
                    ->getDoctrine()
                    ->getRepository(SpecialPredictionVote::class)
                    ->findBy([
                        'specialPrediction' => $predictionResult->getSpecialPrediction()
                    ]);

                foreach ($specialPredictionVotes as $specialPredictionVote)
                {
                    $user =  $specialPredictionVote->getUser();
                    $totalPoints = $user->getTotalPoints();

                    $specialPredictionPoint = $racePointsService->checkSpecialPredictionResults(
                        $specialPredictionVote,
                        $predictionResult
                    );

                    $user->setTotalPoints($totalPoints + $specialPredictionPoint);

                    $manager->persist($user);
                }

            }


            try {
                $manager->flush();
                return $form;

            } catch (BadRequestHttpException $e) {
                $this->addFlash(
                    'error',
                    sprintf(
                        'Unable to save: (Error: %s)',
                        $e->getMessage()
                    )
                );
            }
        }

        return $form;

    }

    protected function getAvailableRace()
    {
        $availableRace = $this
            ->getDoctrine()
            ->getRepository(Race::class)
            ->findAvailableRace();

        if (!$availableRace)
        {
            $this->createNotFoundException(
                'Couldnt find an available race'
            );
        }

        return $availableRace;
    }
}
