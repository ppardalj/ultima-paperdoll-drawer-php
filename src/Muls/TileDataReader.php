<?php

namespace Ultima\Muls;

class TileDataReader
{
    /** @var BinaryFileReader */
    private $reader;

    public function __construct(string $tileDataFilePath)
    {
        $this->reader = new BinaryFileReader($tileDataFilePath);
        $this->reader->open();
    }

    public function __destruct()
    {
        $this->reader->close();
    }

    /**
     * @param int $index
     * @return ItemData
     * @throw IOException
     */
    public function readItemData(int $index): ItemData
    {
        $group = intval($index / 32);
        $groupIdx = $index % 32;

        $position = 493568 // Land data = 16384*30 (from bodys) +(16384/32)*4 (from headers)
            + ((4 + 41 * 32) * $group) // skip groups
            + 4 // header of the current section
            + $groupIdx * 41; // skip entries

        $this->reader->seek($position, SEEK_SET);
        $flags = $this->reader->readInt32();

        $this->reader->seek(10, SEEK_CUR);
        $value = $this->reader->readInt16();

        return new ItemData($flags, $value);
    }
}
