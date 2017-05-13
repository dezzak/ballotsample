<?php

namespace Dezzak\BallotSample;

class Poll
{
    /** @var string */
    private $description;

    /** @var Candidate[] */
    private $candidates = [];

    /**
     * Poll constructor.
     * @param string $description
     */
    public function __construct($description)
    {
        $this->description = $description;
    }

    public function addCandidate(Candidate $candidate)
    {
        $this->candidates[] = $candidate;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Candidate[]
     */
    public function getCandidates()
    {
        return $this->candidates;
    }
}
