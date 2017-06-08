<?php

namespace Dezzak\BallotSample;

class Poll
{
    /** @var string */
    private $description;

    /** @var Candidate[] */
    private $candidates = [];

    /** @var \DateTimeInterface */
    private $date;

    /**
     * Poll constructor.
     * @param string $description
     */
    public function __construct($description, \DateTimeInterface $date)
    {
        $this->description = $description;
        $this->date = $date;
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

    public function getDate()
    {
        return $this->date;
    }
}
