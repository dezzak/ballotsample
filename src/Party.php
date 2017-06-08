<?php

namespace Dezzak\BallotSample;

class Party
{
    /** @var string */
    private $name;
    /** @var string */
    private $logoPath;

    /**
     * Party constructor.
     * @param string $name
     * @param string $logoPath
     */
    public function __construct($name, $logoPath)
    {
        $this->name = $name;
        $this->logoPath = $logoPath;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

}
