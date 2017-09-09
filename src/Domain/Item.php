<?php

namespace Ultima\Domain;

class Item
{
    /** @var int */
    private $itemId;

    /** @var int */
    private $hue;

    /** @var int */
    private $layer;

    /**
     * Item constructor.
     * @param int $itemId
     * @param int $hue
     * @param int $layer
     */
    public function __construct(int $itemId, int $hue, int $layer)
    {
        $this->itemId = $itemId;
        $this->hue = $hue;
        $this->layer = $layer;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @return int
     */
    public function getHue(): int
    {
        return $this->hue;
    }

    /**
     * @return int
     */
    public function getLayer(): int
    {
        return $this->layer;
    }
}
