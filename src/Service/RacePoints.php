<?php

namespace App\Service;

use App\Entity\RacePrediction;
use App\Entity\RaceResult;
use App\Entity\SpecialPredictionResult;
use App\Entity\SpecialPredictionVote;

class RacePoints
{
    /**
     * @param \App\Entity\RaceResult     $raceResult
     * @param \App\Entity\RacePrediction $racePrediction
     * @return int
     */
    public function checkRacePredictionResults(RaceResult $raceResult, RacePrediction $racePrediction)
    {
        $totalPoints = 0;

        $fastestTimeResult = $raceResult->getFastestTime();
        $fastestTimeResultFilter = filter_var($fastestTimeResult, FILTER_SANITIZE_NUMBER_INT);

        $fastestTimePrediction = $racePrediction->getFastestTime();
        $fastestTimePredictionFilter = filter_var($fastestTimePrediction, FILTER_SANITIZE_NUMBER_INT);

        $resultTimeCompareToPrediction = $fastestTimeResultFilter - $fastestTimePredictionFilter;
        $predictionTimeCompareToResult = $fastestTimePredictionFilter - $fastestTimeResultFilter;

        if ($fastestTimeResultFilter === $fastestTimePredictionFilter)
        {
            $totalPoints = $totalPoints + 10;
        }
        elseif (
            ($resultTimeCompareToPrediction < 50 && $resultTimeCompareToPrediction > 0) ||
            ($predictionTimeCompareToResult < 50 && $predictionTimeCompareToResult > 0)
        )
        {
            $totalPoints = $totalPoints + 5;
        }
        elseif (
            ($resultTimeCompareToPrediction < 100 && $resultTimeCompareToPrediction > 0) ||
            ($predictionTimeCompareToResult < 100 && $predictionTimeCompareToResult > 0)
        )
        {
            $totalPoints = $totalPoints + 3;
        }
        elseif (
            ($resultTimeCompareToPrediction < 200 && $resultTimeCompareToPrediction > 0) ||
            ($predictionTimeCompareToResult < 200 && $predictionTimeCompareToResult > 0)
        )
        {
            $totalPoints = $totalPoints + 2;
        }

        if ($raceResult->getFastestDriverInQuali() === $racePrediction->getFastestDriverInQuali())
        {
            $totalPoints = $totalPoints + 1;
        }

        if ($raceResult->getFastestDriverInRace() === $racePrediction->getFastestDriverInRace())
        {
            $totalPoints = $totalPoints + 1;
        }

        if ($raceResult->getFirstPlaceDriver() === $racePrediction->getFirstPlaceDriver())
        {
            $totalPoints = $totalPoints + 1;
        }

        if ($raceResult->getSecondPlaceDriver() === $racePrediction->getSecondPlaceDriver())
        {
            $totalPoints = $totalPoints + 1;
        }

        if ($raceResult->getThirdPlaceDriver() === $racePrediction->getThirdPlaceDriver())
        {
            $totalPoints = $totalPoints + 1;
        }

        if ($raceResult->getTierMax() === $racePrediction->getTierMax())
        {
            $totalPoints = $totalPoints + 1;
        }

        return $totalPoints;

    }

    /**
     * @param \App\Entity\SpecialPredictionVote   $specialPredictionVote
     * @param \App\Entity\SpecialPredictionResult $specialPredictionResult
     * @return int
     */
    public function checkSpecialPredictionResults(SpecialPredictionVote $specialPredictionVote, SpecialPredictionResult $specialPredictionResult)
    {
        $totalPoints = 0;

        if ($specialPredictionVote->getIsHappening() === null || $specialPredictionResult->isHappened() === null){
            return $totalPoints;
        }
        elseif ($specialPredictionVote->getIsHappening() === $specialPredictionResult->isHappened())
        {
            $totalPoints += 1;
        } else
        {
            $totalPoints -= 1;
        }

        return $totalPoints;

    }
}