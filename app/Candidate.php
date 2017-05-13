<?php

namespace Dezzak\BallotSample;

/**
 * Created by PhpStorm.
 * User: Derek Kaye
 * Date: 13/05/17
 * Time: 16:55
 */
class Candidate
{
    private $surname;
    private $firstNames;

    /**
     * Candidate constructor.
     * @param string $surname
     * @param string $firstNames
     */
    public function __construct($surname, $firstNames)
    {
        $this->surname = $surname;
        $this->firstNames = $firstNames;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getFirstNames()
    {
        return $this->firstNames;
    }

}
