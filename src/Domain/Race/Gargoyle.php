<?php

namespace Ultima\Domain\Race;

use Ultima\Domain\Race;
use Ultima\Domain\RaceType;

class Gargoyle extends Race
{
    public function getType()
    {
        return RaceType::GARGOYLE;
    }

    public function getBodyId(bool $female): int
    {
        return ($female ? 665 : 666);
    }
}
