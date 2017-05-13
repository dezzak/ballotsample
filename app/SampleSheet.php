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
        $this->generateBoxInfo();
        $this->generateCandidateSamples();
    }

    private function generateHeader()
    {
        $this->setFont(self::FONT_FACE, 'B', 15);
        $this->Cell(190, 10, $this->poll->getDescription(), 1, 0, 'C');
        $this->Ln();
    }

    private function generateCandidateSamples()
    {
        foreach ($this->poll->getCandidates() as $candidate) {
            $this->generateCandidateSample($candidate);
        }
    }

    private function generateCandidateSample(Candidate $candidate)
    {
        $name = strtoupper($candidate->getSurname()) . ', ' . explode(' ', $candidate->getFirstNames())[0];

        $this->setFont(self::FONT_FACE, '', 12);
        $infoWidth = 40;
        $this->Cell($infoWidth, 9, $name, 1);

        $this->generateSampleLine();
        $this->Cell($infoWidth);
        $this->generateSampleLine();
        $this->Cell($infoWidth);
        $this->generateSampleLine();
        $this->Ln();
    }

    private function generateSampleLine()
    {
        $this->SetFont(self::FONT_FACE, '', 6);
        $this->SetDrawColor(0x99);
        for ($i = 1; $i <= 50; ++$i) {
            $this->Cell(3, 3, $i, 1, 0, 'C');
        }
        $this->SetDrawColor(0);
        $this->Ln();
    }

    private function generateBoxInfo()
    {
        $this->setFont(self::FONT_FACE, 'B', 10);
        $lineHeight = 8;
        $this->Cell(25, $lineHeight, 'Box Location');
        $this->Cell(165, $lineHeight, '', 'B');
        $this->Ln();
        $this->Cell(25, $lineHeight, 'Box Number');
        $this->Cell(70, $lineHeight, '', 'B');
        $this->Cell(25, $lineHeight, 'Polling District');
        $this->Cell(70, $lineHeight, '', 'B');
        $this->Ln(12);
    }
}
