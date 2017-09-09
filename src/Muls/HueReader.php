<?php

namespace Ultima\Muls;

use Ultima\Muls\Exception\IOException;

class HueReader
{
    /** @var BinaryFileReader */
    private $reader;

    public function __construct(string $hueFilePath)
    {
        $this->reader = new BinaryFileReader($hueFilePath);
        $this->reader->open();
    }

    public function __destruct()
    {
        $this->reader->close();
    }

    /**
     * @param int $id
     * @return Hue
     * @throws IOException
     */
    public function readHue(int $id)
    {
        $id -= 1;
        $id &= 0x7fff;

        $hueOffset = 4 + $id * 88;
        $colorOffset = intval($id / 8) * 4;
        $this->reader->seek($hueOffset + $colorOffset, SEEK_SET);

        $colors = [];
        for ($i = 0; $i < Hue::COLOR_LENGTH; $i++) {
            $colors[$i] = $this->reader->readInt16() | 0x8000;
        }

        return new Hue($id, $colors);
    }
}
