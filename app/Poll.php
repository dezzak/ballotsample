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
        usort($this->candidates, [$this, 'sortCandidate']);
        return $this->candidates;
    }

    private function sortCandidate(Candidate $candidateA, Candidate $candidateB)
    {
        if ($candidateA->getSurname() === $candidateB->getSurname()) {
            return 0;
        }
        return $candidateA->getSurname() < $candidateB->getSurname() ? -1 : 1;
    }
}
