<?php

namespace Ultima\PaperdollDrawer;

use Ultima\PaperdollDrawer\Entry\BodyEntry;
use Ultima\PaperdollDrawer\Entry\ItemEntry;

class Paperdoll
{
    /** @var string */
    private $name;

    /** @var string */
    private $title;

    /** @var BodyEntry */
    private $bodyEntry;

    /** @var ItemEntry[] */
    private $itemEntries;

    /**
     * Paperdoll constructor.
     * @param string $name
     * @param string $title
     * @param BodyEntry $bodyEntry
     * @param ItemEntry[] $itemEntries
     */
    public function __construct(string $name, string $title, BodyEntry $bodyEntry, array $itemEntries)
    {
        $this->name = $name;
        $this->title = $title;
        $this->bodyEntry = $bodyEntry;
        $this->itemEntries = $itemEntries;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return BodyEntry
     */
    public function getBodyEntry(): BodyEntry
    {
        return $this->bodyEntry;
    }
    /**
     * @return ItemEntry[]
     */
    public function getItemEntries(): array
    {
        return $this->itemEntries;
    }
}
