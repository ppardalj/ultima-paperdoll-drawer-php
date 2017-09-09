<?php

namespace Ultima\Muls;

class ItemData
{
    /** @var int */
    private $flags;

    /** @var int */
    private $value;

    /**
     * ItemData constructor.
     * @param int $flags
     * @param int $value
     */
    public function __construct(int $flags, int $value)
    {
        $this->flags = $flags;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param int $flag
     * @return bool
     */
    public function hasFlag(int $flag): bool
    {
        return $this->flags & $flag;
    }

    /**
     * @return bool
     */
    public function isWearable(): bool
    {
        return $this->hasFlag(TileFlag::WEARABLE);
    }
}
