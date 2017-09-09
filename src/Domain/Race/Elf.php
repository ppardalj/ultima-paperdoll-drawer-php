<?php

namespace Ultima\Domain\Race;

use Ultima\Domain\Race;
use Ultima\Domain\RaceType;

class Elf extends Race
{
    public function getType()
    {
        return RaceType::ELF;
    }

    public function getBodyId(bool $female): int
    {
        return ($female ? 15 : 14);
    }
}
