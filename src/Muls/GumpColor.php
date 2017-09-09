<?php

namespace Ultima\Muls;

class GumpColor
{
    public static function fromColor($color): GumpColor
    {
        $r = $color >> 10;
        $g = ($color >> 5) & 0x1F;
        $b = $color & 0x1F;

        return new self($r, $g, $b);
    }

    /** @var int */
    public $r;

    /** @var int */
    public $g;

    /** @var int */
    public $b;

    public function __construct(int $r, int $g, int $b)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }

    /**
     * @return bool
     */
    public function isBlack(): bool
    {
        return $this->r == 0 && $this->g == 0 && $this->b == 0;
    }

    /**
     * @return bool
     */
    public function isGray(): bool
    {
        return $this->r == $this->g && $this->r == $this->b;
    }


    /**
     * @param Hue $hue
     * @return GumpColor
     */
    public function withHue(Hue $hue): GumpColor
    {
        $r = (($hue->color($this->r) >> 10));
        $g = (($hue->color($this->r) >> 5) & 0x1F);
        $b = ($hue->color($this->r) & 0x1F);

        return new self($r, $g, $b);
    }
}
