<?php

namespace App\Controller;

use App\Entity\SpecialPredictionVote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpecialPredictionVoteController extends AbstractController
{
    /**
     * @Route("/special-prediction-vote/create", name="special_prediction_vote_create")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $specialPredictionVote = new SpecialPredictionVote();


        $manager = $this->getDoctrine()->getManager();

        $specialPredictionVote->setUser($this->getUser());
        $specialPredictionVote->setSpecialPrediction();

        $manager->persist($specialPredictionVote);
//        $company = $homeFormRequest->get('company');
//        $email = $homeFormRequest->get('email');

        return $this->redirect($this->generateUrl('special_prediction'));
    }
}
