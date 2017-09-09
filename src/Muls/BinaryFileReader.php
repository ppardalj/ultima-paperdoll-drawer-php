<?php

namespace Ultima\Muls;

use Ultima\Muls\Exception\IOException;

class BinaryFileReader
{
    private $path;
    private $handle;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @throws IOException
     */
    public function open()
    {
        if (!$this->handle) {
            $this->handle = fopen($this->path, 'r');
            if (!$this->handle) {
                throw new IOException("Unable to open {$this->path}");
            }
        }
    }

    /**
     * @return int
     * @throws IOException
     */
    public function readInt16(): int
    {
        return (int)$this->readBigToLittleEndian(2);
    }

    /**
     * @return int
     * @throws IOException
     */
    public function readInt32(): int
    {
        return (int)$this->readBigToLittleEndian(4);
    }

    /**
     * @param int $length
     * @return array|string
     * @throws IOException
     */
    public function readBigToLittleEndian(int $length)
    {
        if (($val = fread($this->handle, $length)) === false) {
            throw new IOException("Error while reading $length bytes from file {$this->path}");
        }
        switch ($length) {
            case 4:
                $val = unpack('l', $val);
                break;
            case 2:
                $val = unpack('s', $val);
                break;
            case 1:
                $val = unpack('c', $val);
                break;
            default:
                $val = unpack('l*', $val);
                return $val;
        }
        return ($val[1]);
    }

    public function seek($offset, $whence)
    {
        return fseek($this->handle, $offset, $whence);
    }

    public function eof()
    {
        return feof($this->handle);
    }

    public function close()
    {
        if ($this->handle) {
            fclose($this->handle);
            $this->handle = null;
        }
    }
}
