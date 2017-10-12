<?php

namespace Ultima\PaperdollDrawer;

use Ultima\Muls\GumpArtReader;
use Ultima\Muls\GumpIndexReader;
use Ultima\Muls\HueReader;
use Ultima\Muls\TileDataReader;
use Ultima\PaperdollDrawer\Entry\GumpEntry;

class PaperdollDrawer
{
    /**
     * @param string $mulPath
     * @return PaperdollDrawer
     */
    public static function with(string $mulPath): self
    {
        $mulPath = rtrim($mulPath, '/');
        
        return new PaperdollDrawer(
            new GumpIndexReader("{$mulPath}/gumpidx.mul"),
            new GumpArtReader("{$mulPath}/gumpart.mul"),
            new TileDataReader("{$mulPath}/tiledata.mul"),
            new HueReader("{$mulPath}/hues.mul")
        );
    }

    /** @var GumpIndexReader */
    private $gumpIndexReader;

    /** @var GumpArtReader */
    private $gumpArtReader;

    /** @var TileDataReader */
    private $tileDataReader;

    /** @var HueReader */
    private $hueReader;

    public function __construct(
        GumpIndexReader $gumpIndexReader,
        GumpArtReader $gumpArtReader,
        TileDataReader $tileDataReader,
        HueReader $hueReader)
    {
        $this->hueReader = $hueReader;
        $this->gumpIndexReader = $gumpIndexReader;
        $this->gumpArtReader = $gumpArtReader;
        $this->tileDataReader = $tileDataReader;
    }

    /**
     * @param Paperdoll $paperdoll
     * @return resource
     */
    public function drawPaperdoll(Paperdoll $paperdoll)
    {
        $canvas = imagecreatefrompng(__DIR__ . '/../../resource/paperdoll.png');
        if (!$canvas) {
            throw new \RuntimeException('could not create paperdoll image');
        }

        imagealphablending($canvas, true);

        $this->addEntry($canvas, $paperdoll->getBodyEntry());

        foreach ($paperdoll->getItemEntries() as $entry) {
            $this->addEntry($canvas, $entry);
        }

        $this->addText($canvas, $paperdoll->getName(), 266);
        $this->addText($canvas, $paperdoll->getTitle(), 283);

        return $canvas;
    }

    private function addEntry(&$canvas, GumpEntry $entry)
    {
        $index = $entry->getIndex();
        if ($index > 0xFFFF || $index <= 0) {
            return;
        }

        if ($entry->isGump()) { // Male/Female Gumps or IsGump Param
            $gumpId = $index;
        } else {
            $itemData = $this->tileDataReader->readItemData($index);

            if (!$itemData->isWearable()) {
                return;
            } else {
                $gumpId = $itemData->value();
                if ($gumpId < 10000) {
                    if ($entry->isFemale()) {
                        $gumpId += 60000;
                    } else {
                        $gumpId += 50000;
                    }
                }
            }
        }

        $this->loadRawGump($canvas, intval($gumpId), $entry->getHue());
    }

    private function loadRawGump(&$canvas, int $index, int $hueId)
    {
        $hue = ($hueId > 0) ? $this->hueReader->readHue($hueId) : null;
        $gumpData = $this->gumpIndexReader->readGumpData($index);
        $data = $this->gumpArtReader->readGump($gumpData, $hue);

        foreach ($data as $datum) {
            $this->addGump($canvas, $datum);
        }
    }

    private function addGump(&$canvas, $datum)
    {
        $x = intval($datum[0]) + 8;
        $y = intval($datum[1]) + 15;
        $r = intval($datum[2]);
        $g = intval($datum[3]);
        $b = intval($datum[4]);
        $length = intval($datum[5]); // pixel color repeat length
        if ($r || $g || $b) {
            $color = imagecolorallocate($canvas, $r, $g, $b);
            for ($i = 0; $i < $length; $i++) {
                imagesetpixel($canvas, $x + $i, $y, $color);
            }
        }
    }

    private function addText(&$canvas, $text, $y)
    {
        $textColor = imagecolorallocate($canvas, 0, 0, 0);
        $pos = (int)(131 - (strlen($text) * 3.5));
        if ($pos < 0) {
            $pos = 0;
        }
        imagestring($canvas, 3, $pos, $y, $text, $textColor);
    }
}
