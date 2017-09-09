<?php

namespace Ultima\PaperdollDrawer\Entry;

abstract class GumpEntry
{
    /** @var int */
    private $index;

    /** @var int */
    private $hue;

    /** @var bool */
    private $female;

    public function __construct(int $index, int $hue, bool $female)
    {
        $this->index = $index;
        $this->hue = $hue;
        $this->female = $female;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @return int
     */
    public function getHue(): int
    {
        if ($this->hue < 1 || $this->hue > 65535) {
            return 0;
        }

        return $this->hue;
    }

    /**
     * @return bool
     */
    public function isFemale(): bool
    {
        return $this->female;
    }

    /**
     * @return bool
     */
    public abstract function isGump(): bool;
}
