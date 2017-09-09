<?php

namespace Ultima\Domain\Race;

use Ultima\Domain\Race;
use Ultima\Domain\RaceType;

class Human extends Race
{
    public function getType()
    {
        return RaceType::HUMAN;
    }

    public function getBodyId(bool $female): int
    {
        return ($female ? 13 : 12);
    }
}
