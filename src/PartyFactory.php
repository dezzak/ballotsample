<?php

namespace Dezzak\BallotSample;

class PartyFactory
{
    /** @var Party[] */
    private $parties;

    public function createParty($name, $imagePath)
    {
        $existingParty = $this->getParty($name);
        if ($existingParty) {
            return $existingParty;
        }
        $this->parties[$name] = new Party($name, $imagePath);
        return $this->parties[$name];
    }

    public function getParty($name)
    {
        if (isset($this->parties[$name])) {
            return $this->parties[$name];
        }
        return null;
    }

    public function buildBaseParties()
    {
        $this->createParty('Conservatives', __DIR__ . '/../resources/conservatives.gif');
        $this->createParty('Labour', __DIR__ . '/../resources/labour.gif');
        $this->createParty('Liberal Democrats', __DIR__ . '/../resources/libdem.jpg');
        $this->createParty('Green', __DIR__ . '/../resources/green.jpg');
        $this->createParty('UKIP', __DIR__ . '/../resources/ukip.gif');
    }
}
