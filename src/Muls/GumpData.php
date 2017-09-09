<?php

namespace Ultima\Muls;

class GumpData
{
    /**
     * @var int
     */
    private $size;
    /**
     * @var int
     */
    private $width;
    /**
     * @var int
     */
    private $height;
    /**
     * @var int
     */
    private $lookup;

    /**
     * GumpData constructor.
     * @param int $size
     * @param int $width
     * @param int $height
     * @param int $lookup
     */
    public function __construct(int $size, int $width, int $height, int $lookup)
    {
        $this->size = $size;
        $this->width = $width;
        $this->height = $height;
        $this->lookup = $lookup;
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function width(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function height(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function lookup(): int
    {
        return $this->lookup;
    }
}
