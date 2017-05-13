<?php

namespace Dezzak\BallotSample;

class SampleSheet extends \FPDF
{
    const FONT_FACE = 'Times';
    /** @var Poll */
    private $poll;

    /** @return Poll */
    public function getPoll()
    {
        return $this->poll;
    }

    public function setPoll(Poll $poll)
    {
        $this->poll = $poll;
    }

    public function generate()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->setFont(self::FONT_FACE, '', 12);

        $this->generateHeader();
    }

    private function generateHeader()
    {
        $this->setFont(self::FONT_FACE, 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, $this->poll->getDescription(), 1, 0, 'C');
        $this->Ln(20);
    }
}
