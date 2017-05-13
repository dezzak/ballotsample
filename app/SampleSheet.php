<?php

namespace Dezzak\BallotSample;

class SampleSheet extends \FPDF
{
    const FONT_FACE = 'Times';
    /** @var Poll */
    private $poll;

    /** @var int */
    private $endOfHeader;

    /** @var int */
    private $sampleHeight;
    /** @var int */
    private $sampleCount;

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
        while (($this->GetY() + $this->sampleHeight) < 280) {
            $this->generateBoxInfo();
            $this->generateCandidateSamples();
            if (!$this->sampleHeight) {
                $this->sampleHeight = $this->GetY() - $this->endOfHeader;
            }
        }
    }

    private function generateHeader()
    {
        $this->setFont(self::FONT_FACE, 'B', 15);
        $this->Cell(190, 10, $this->poll->getDescription(), 1, 0, 'C');
        $this->Ln();
        $this->endOfHeader = $this->GetY();
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
        $infoWidth = 55;
        $preImageX = $this->GetX();
        $preImageY = $this->GetY();
        $this->Image($candidate->getParty()->getLogoPath(), null, null, 9, 9);
        $this->setXY($preImageX, $preImageY);
        $this->Cell(9, 9, '', 1);
        $this->Cell(46, 9, $name, 1);

        $this->sampleCount = 1;
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
        for ($i = 1; $i <= 45; ++$i) {
            $this->Cell(3, 3, ($this->sampleCount % 100), 1, 0, 'C');
            $this->sampleCount++;
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
