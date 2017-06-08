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
    /** @var string */
    private $surname;
    /** @var string */
    private $firstNames;
    /** @var Party */
    private $party;

    /**
     * Candidate constructor.
     * @param string $surname
     * @param string $firstNames
     * @param Party $party
     */
    public function __construct($surname, $firstNames, Party $party)
    {
        $this->surname = $surname;
        $this->firstNames = $firstNames;
        $this->party = $party;
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

    /**
     * @return Party
     */
    public function getParty()
    {
        return $this->party;
    }
}
