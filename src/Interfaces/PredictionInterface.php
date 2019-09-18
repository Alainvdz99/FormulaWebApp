<?php

namespace App\Interfaces;

interface PredictionInterface
{
    /*
     * Fastest Time in the whole race weekend
     */
    public function getFastestTime();

    /*
     * Fastest driver in the quali
     */
    public function getFastestDriverInQuali();

    /*
     * Fastest Time in the race
     */
    public function getFastestDriverInRace();

    /*
     * First place driver in race
     */
    public function getFirstPlaceDriver();

    /*
     * Seccond place driver in race
     */
    public function getSecondPlaceDriver();

    /*
     * Third place driver in race
     */
    public function getThirdPlaceDriver();

    /*
     * Tier Max on start race
     */
    public function getTierMax(): ?string;

}