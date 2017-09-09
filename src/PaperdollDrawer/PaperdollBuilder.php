<?php

namespace Ultima\PaperdollDrawer;

use Ultima\Domain\Race\Human;
use Ultima\PaperdollDrawer\Entry\BodyEntry;
use Ultima\PaperdollDrawer\Entry\ItemEntry;
use Ultima\Domain\Item;
use Ultima\Domain\Race;

class PaperdollBuilder
{
    public static function create(string $name): self
    {
        return new self($name);
    }

    /** @var string */
    private $name = '';

    /** @var string */
    private $title = '';

    /** @var bool */
    private $female = false;

    /** @var $race */
    private $race;

    /** @var int */
    private $skinHue = 0;

    /** @var Item */
    private $items = [];

    private function __construct(string $name)
    {
        $this->name = $name;
        $this->race = Human::race();
    }

    /**
     * @param string $title
     * @return PaperdollBuilder
     */
    public function withTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param bool $female
     * @return PaperdollBuilder
     */
    public function withFemale(bool $female): self
    {
        $this->female = $female;
        return $this;
    }

    /**
     * @param Race $race
     * @return PaperdollBuilder
     */
    public function withRace(Race $race): self
    {
        $this->race = $race;
        return $this;
    }

    /**
     * @param int $skinHue
     * @return PaperdollBuilder
     */
    public function withSkinHue(int $skinHue): self
    {
        $this->skinHue = $skinHue;
        return $this;
    }

    /**
     * @param Item $item
     * @return PaperdollBuilder
     */
    public function withItem(Item $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return Paperdoll
     */
    public function build(): Paperdoll
    {
        $bodyEntry = new BodyEntry($this->race->getBodyId($this->female), $this->skinHue, $this->female);

        $itemEntries = [];
        foreach ($this->items as $item) {
            /** @var Item $item */
            $itemEntries[] = new ItemEntry($item->getItemId(), $item->getHue(), $this->female);
        }

        return new Paperdoll($this->name, $this->title, $bodyEntry, $itemEntries);
    }
}
