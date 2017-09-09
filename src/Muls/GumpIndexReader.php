<?php

namespace Ultima\Muls;

use Ultima\Muls\Exception\IOException;

class GumpIndexReader
{
    /** @var BinaryFileReader */
    private $reader;

    public function __construct(string $gumpIdxFilePath)
    {
        $this->reader = new BinaryFileReader($gumpIdxFilePath);
        $this->reader->open();
    }

    public function __destruct()
    {
        $this->reader->close();
    }

    /**
     * @param int $index
     * @return GumpData
     * @throws IOException
     */
    public function readGumpData(int $index): GumpData
    {
        $this->reader->seek($index * 12, SEEK_SET);
        if ($this->reader->eof()) {
            throw new \InvalidArgumentException('Invalid gump id, reached end of gump index.');
        }

        $lookup = $this->reader->readInt32();
        if ($lookup == -1) {
            if ($index >= 60000) {
                $index -= 10000;
            }
            $this->reader->seek($index * 12, SEEK_SET);
            if ($this->reader->eof()) {
                throw new \InvalidArgumentException('Invalid gump id, reached end of gump index.');
            }
        }
        $gumpSize = $this->reader->readInt32();
        $gumpExtra = $this->reader->readInt32();
        $this->reader->seek($index * 12, SEEK_SET);
        $gumpWidth = (($gumpExtra >> 16) & 0xFFFF);
        $gumpHeight = ($gumpExtra & 0xFFFF);

        if ($gumpHeight <= 0 || $gumpWidth <= 0) {
            throw new \RuntimeException('Gump width or height was less than 0.');
        }

        return new GumpData($gumpSize, $gumpWidth, $gumpHeight, $lookup);
    }
}
