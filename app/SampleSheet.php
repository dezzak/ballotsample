<?php

namespace Dezzak\BallotSample;

use Dezzak\BallotSample\Output\PDFInterface;

class SampleSheet
{
    const FONT_FACE = 'Times';
    const BOX_SIZE = 3;
    const INFO_WIDTH = 55;
    const PAGE_WIDTH = 190;
    const LOGO_SIZE = 9;
    /** @var Poll */
    private $poll;
    /** @var int */
    private $endOfHeader;
    /** @var int */
    private $sampleHeight;
    /** @var int */
    private $sampleCount;
    /** @var PDFInterface */
    private $pdf;

    public function __construct(PDFInterface $pdf)
    {
        $this->pdf = $pdf;
    }

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
        $this->pdf->addPage();
        $this->pdf->setFont(self::FONT_FACE, '', 12);

        $this->generateHeader();
        while (($this->pdf->getY() + $this->sampleHeight) < 280) {
            $this->generateBoxInfo();
            $this->generateCandidateSamples();
            if (!$this->sampleHeight) {
                $this->sampleHeight = $this->pdf->getY() - $this->endOfHeader;
            }
        }
    }

    private function generateHeader()
    {
        $this->pdf->setFont(self::FONT_FACE, 'B', 15);
        $this->pdf->addCell(self::PAGE_WIDTH, 10, $this->poll->getDescription(), 1, 0, 'C');
        $this->pdf->addLine();
        $this->endOfHeader = $this->pdf->getY();
    }

    private function generateBoxInfo()
    {
        $this->pdf->setFont(self::FONT_FACE, 'B', 10);
        $lineHeight = 8;
        $this->pdf->addCell(25, $lineHeight, 'Box Location');
        $this->pdf->addCell(165, $lineHeight, '', 'B');
        $this->pdf->addLine();
        $this->pdf->addCell(25, $lineHeight, 'Box Number');
        $this->pdf->addCell(70, $lineHeight, '', 'B');
        $this->pdf->addCell(25, $lineHeight, 'Polling District');
        $this->pdf->addCell(70, $lineHeight, '', 'B');
        $this->pdf->addLine(12);
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

        $this->pdf->setFont(self::FONT_FACE, '', 12);
        $preImageX = $this->pdf->getX();
        $preImageY = $this->pdf->getY();
        $this->pdf->addImage($candidate->getParty()->getLogoPath(), self::LOGO_SIZE, self::LOGO_SIZE);
        $this->pdf->setXY($preImageX, $preImageY);
        $this->pdf->addCell(self::LOGO_SIZE, self::LOGO_SIZE, '', 1);
        $this->pdf->addCell((self::INFO_WIDTH - self::LOGO_SIZE), self::LOGO_SIZE, $name, 1);

        $numberOfSampleLines = floor(self::LOGO_SIZE / self::BOX_SIZE);

        $this->sampleCount = 1;
        $this->generateSampleLine();

        for (;$numberOfSampleLines > 1; --$numberOfSampleLines) {
            $this->pdf->addCell(self::INFO_WIDTH);
            $this->generateSampleLine();
        }
        $this->pdf->addLine();
    }

    private function generateSampleLine()
    {
        $this->pdf->setFont(self::FONT_FACE, '', 6);
        $this->pdf->setDrawColour(0x99, 0x99, 0x99);

        $mmAvailable = self::PAGE_WIDTH - self::INFO_WIDTH; // page width - info width
        $numberOfBoxes = floor($mmAvailable / self::BOX_SIZE);

        for ($i = 1; $i <= $numberOfBoxes; ++$i) {
            $this->pdf->addCell(self::BOX_SIZE, self::BOX_SIZE, ($this->sampleCount % 100), 1, 0, 'C');
            $this->sampleCount++;
        }
        $this->pdf->SetDrawColour(0, 0, 0);
        $this->pdf->addLine();
    }
}
