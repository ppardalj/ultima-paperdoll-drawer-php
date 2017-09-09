<?php

namespace Ultima\Muls;

use Ultima\Muls\Exception\IOException;

class GumpArtReader
{
    /** @var BinaryFileReader */
    private $reader;

    public function __construct(string $gumpArtFilePath)
    {
        $this->reader = new BinaryFileReader($gumpArtFilePath);
        $this->reader->open();
    }

    public function __destruct()
    {
        $this->reader->close();
    }

    /**
     * @param GumpData $gumpData
     * @param Hue|null $hue
     * @return \Generator
     * @throws IOException
     */
    public function readGump(GumpData $gumpData, Hue $hue = null): \Generator
    {
        $this->reader->seek($gumpData->lookup(), SEEK_SET);
        $heightTable = $this->reader->readBigToLittleEndian($gumpData->height() * 4);
        if ($this->reader->eof()) {
            throw new \InvalidArgumentException('Invalid gumpid, reached end of gumpfile.');
        }

        for ($y = 1; $y < $gumpData->height(); $y++) {
            $this->reader->seek($heightTable[$y] * 4 + $gumpData->lookup(), SEEK_SET);

            // Start of row
            $x = 0;
            while ($x < $gumpData->width()) {
                $rle = $this->reader->readInt32(); // Read the RLE data
                $length = ($rle >> 16) & 0xFFFF; // First two bytes - how many pixels does this color cover
                $color = GumpColor::fromColor($rle & 0xFFFF); // Second two bytes - what color do we apply

                if (!$color->isBlack()) {
                    // Check if we're applying a special hue (skin hues), if so, apply only to grays
                    if ($hue && ($hue->id() <= 0x8000 || $color->isGray())) {
                        $color = $color->withHue($hue);
                    }
                    yield [$x, $y, $color->r * 8, $color->g * 8, $color->b * 8, $length];
                }
                $x += $length;
            }
        }
    }
}
