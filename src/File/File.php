<?php declare(strict_types=1);

namespace Psd\File;

use Exception;
use SplFileObject;

/**
 * An extension of the built-in Php File class that adds numerous helpers for
 * reading/writing binary data.
 *
 */
class File extends SplFileObject implements FileInterface
{
    /**
     * All of the formats and their pack codes that we want to be able to convert into
     * methods for easy reading/writing.
     *
     * @var array
     */
    const FORMATS = [
//        'ulonglong' => [
//            'length' => 8,
//            'code'  => 'J',
//            'convert_little2big' => false,
//        ],
        'longlong' => [
            'length' => 8,
            'code' => 'q',
            'convert_little2big' => true,
        ],
        'double' => [
            'length' => 8,
            'code' => 'E',
            'convert_little2big' => false,
        ],
        'float' => [
            'length' => 4,
            'code' => 'g',
            'convert_little2big' => false,
        ],
        'uint' => [
            'length' => 4,
            'code' => 'N',
            'convert_little2big' => false,
        ],
        'int' => [
            'length' => 4,
            'code' => 'l',
            'convert_little2big' => true,
        ],
        'ushort' => [
            'length' => 2,
            'code' => 'n',
            'convert_little2big' => false,
        ],
        'short' => [
            'length' => 2,
            'code' => 's',
            'convert_little2big' => true,
        ],
        'int_le' => [
            'length' => 4,
            'code' => 'l',
            'convert_little2big' => false,
        ],
    ];

    /**
     * @var bool
     */
    protected bool $littleEndian;

    /**
     * File constructor.
     *
     * @param $fileName
     * @param string $openMode
     * @param false $useIncludePath
     * @param null $context
     */
    public function __construct($fileName, $openMode = 'r', $useIncludePath = false, $context = null)
    {
        parent::__construct($fileName, $openMode, $useIncludePath, $context);
        $this->isLittleEndian();
    }

    /**
     * @param $method
     * @param $params
     *
     * @return mixed
     *
     * @throws Exception
     */
    protected function getData($formatKey, $convertL2B = null)
    {
        $length = static::FORMATS[$formatKey]['length'];
        $code = static::FORMATS[$formatKey]['code'];
        $convert = $convertL2B ?? static::FORMATS[$formatKey]['convert_little2big'];

        $str = $this->fRead($length);

        // Convert little to big only if OS use little
        if (true === $convert && true === $this->littleEndian) {
            $str = $this->lEndian2bEndian($str);
        }

        return unpack($code, $str)[1];
    }

    public function readIntLE(): int
    {
        return $this->getData('int_le');
    }

    public function readLongLong(): int
    {
        return $this->getData('longlong');
    }

    public function readDouble(): float
    {
        return $this->getData('double');
    }

    public function readFloat(): float
    {
        return $this->getData('float');
    }

    public function readUint(): int
    {
        return $this->getData('uint');
    }

    public function readInt(): int
    {
        return $this->getData('int');
    }

    public function readUShort(): int
    {
        return $this->getData('ushort');
    }

    public function readShort(): int
    {
        return $this->getData('short');
    }

    /**
     * @param $size
     * @param ?callable $func
     *
     * @return array
     *
     * @throws Exception
     */
    public function readBytes($size, callable $func = null): array
    {
        $bin = $this->fRead($size);
        $hex = bin2hex($bin);
        $data = str_split($hex, 2);

        foreach ($data as &$val) {
            $val = hexdec($val);

            if (isset($func)) {
                $val = $func($val);
            }
        }

        return $data;
    }

    /**
     * @return float|int
     *
     * @throws Exception
     */
    public function readByte()
    {
        $bin = $this->fRead(1);

        return hexdec(bin2hex($bin));
    }

    /**
     * Reads a boolean value.
     * @return bool
     *
     * @throws Exception
     */
    public function readBoolean(): bool
    {
        return $this->readByte() !== 0;
    }

    /**
     * Reads a 32-bit color space value.
     *
     * @return array
     */
    public function readSpaceColor(): array
    {
        $colorSpace = $this->readShort();
        $colorComponents = [];

        for ($i = 0; $i < 4; $i++) {
            $colorComponents[] = ($this->readShort() >> 8);
        }

        return [
            'color_mode' => $colorSpace,
            'color_components' => $colorComponents,
        ];
    }

    /**
     * Reads a string of the given length and converts it to UTF-8 from the internally used MacRoman encoding.
     *
     * @param null $length
     *
     * @return string
     *
     * @throws Exception
     */
    public function readString($length = null): string
    {
        if (!isset($length)) {
            $length = $this->readByte();
        }

        return str_replace("\000", '', $this->fRead($length));
    }

    /**
     * Reads a unicode string, which is double the length of a normal string and encoded as UTF-16.
     *
     * @param null $length
     *
     * @return false|string|string[]
     *
     * @throws Exception
     */
    public function readUnicodeString($length = null): string
    {
        if (!isset($length)) {
            $length = $this->readInt();
        }

        if (!isset($length) || $length <= 0) {
            return '';
        }

        $stringU16 = $this->fRead($length * 2);

        return str_replace("\000", '', iconv('UTF-16BE', 'UTF-8', $stringU16));
    }

    /**
     * Adobe's lovely signed 32-bit fixed-point number with 8bits.24bits
     * http://www.adobe.com/devnet-apps/photoshop/fileformatashtml/PhotoshopFileFormats.htm#50577409_17587
     *
     * @return float|int|mixed
     *
     * @throws Exception
     */
    public function readPathNumber(): float
    {
        return current(unpack('c*', $this->fRead(1))) +
            hexdec(current(unpack('H*', $this->fRead(3)))) / pow(2, 24);
    }


    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     *
     * @throws Exception
     */
    public function ffseek(int $amt, bool $rel = false): int
    {
        $status = parent::fseek($amt, $rel ? SEEK_CUR : SEEK_SET);
        $this->validateDefaultMethod($status === 0);

        return $status;
    }

    /**
     * @param $length
     *
     * @return string
     *
     * @throws Exception
     */
    public function read($length): string
    {
        return $this->validateDefaultMethod(parent::fread($length));
    }

    /**
     * @return int
     *
     * @throws Exception
     */
    public function tell(): int
    {
        return $this->validateDefaultMethod(parent::ftell());
    }

    /**
     * @param mixed $data
     *
     * @return mixed
     *
     * @throws Exception
     */
    protected function validateDefaultMethod($data)
    {
        if (false === $data) {
            throw new Exception('File error.');
        }

        return $data;
    }

    /**
     * Convert Little endian to big endian
     * @param $num
     *
     * @return string
     */
    protected function lEndian2bEndian($num): string
    {
        $data = bin2hex($num);
        if (strlen($data) <= 2) {
            return $num;
        }
        $u = unpack("H*", strrev(pack("H*", $data)));

        return hex2bin($u[1]);
    }

    /**
     * @return void
     */
    protected function isLittleEndian(): void
    {
        $testInt = 0x00FF;
        $p = pack('S', $testInt);
        $this->littleEndian = ($testInt === current(unpack('v', $p)));
    }
}
