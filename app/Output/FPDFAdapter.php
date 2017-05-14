<?php

namespace Dezzak\BallotSample\Output;

class FPDFAdapter implements PDFInterface
{
    /** @var \FPDF */
    private $fpdf;

    public function __construct(\FPDF $fpdf)
    {
        $this->fpdf = $fpdf;
    }

    public function addPage()
    {
        $this->fpdf->AddPage();
    }

    public function setFont($family, $style = '', $size = 0)
    {
        $this->fpdf->SetFont($family, $style, $size);
    }

    public function setDrawColour($red, $green, $blue)
    {
        $this->fpdf->SetDrawColor($red, $green, $blue);
    }

    public function getX()
    {
        return $this->fpdf->GetX();
    }

    public function getY()
    {
        return $this->fpdf->GetY();
    }

    public function setXY($xPos, $yPos)
    {
        $this->fpdf->SetXY($xPos, $yPos);
    }

    public function addCell($width, $height = 0, $text = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->fpdf->Cell($width, $height, $text, $border, $ln, $align, $fill, $link);
    }

    public function addLine($height = null)
    {
        $this->fpdf->Ln($height);
    }

    public function addImage($filePath, $width = 0, $height = 0)
    {
        $this->fpdf->Image($filePath, null, null, $width, $height);
    }
}
