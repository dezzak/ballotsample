<?php
/**
 * Created by PhpStorm.
 * User: Derek Kaye
 * Date: 14/05/17
 * Time: 16:02
 */

namespace Dezzak\BallotSample\Output;

interface PDFInterface
{
    public function addPage();

    public function setFont($family, $style = '', $size = 0);

    public function setDrawColour($red, $green, $blue);

    public function getX();

    public function getY();

    public function setXY($xPos, $yPos);

    public function addCell(
        $width,
        $height = 0,
        $text = '',
        $border = 0,
        $ln = 0,
        $align = '',
        $fill = false,
        $link = ''
    );

    public function addLine($height = null);

    public function addImage($filePath, $width = 0, $height = 0);

    public function outputToFile($fileName);

    public function getStringWidth($string);
}