<?php

namespace Ultima\Muls;

class Hue
{
    const COLOR_LENGTH = 32;

    /**
     * @var int
     */
    private $id;
    /**
     * @var int[]
     */
    private $colors;

    public function __construct(int $id, array $colors)
    {
        if (count($colors) != self::COLOR_LENGTH) {
            throw new \InvalidArgumentException('bad hue color length: ' . count($colors));
        }

        $this->id = $id;
        $this->colors = $colors;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @param int $index
     * @return int
     */
    public function color(int $index): int
    {
        if ($index < 0 || $index > self::COLOR_LENGTH) {
            throw new \InvalidArgumentException('hue color index out of bounds: ' . $index);
        }

        return $this->colors[$index];
    }
}
