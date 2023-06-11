<?php

use PHPUnit\Framework\TestCase;
use Psd\Helper;

class HelperTest extends TestCase
{
    /**
     * @dataProvider pad2Data
     */
    public function testPad2($number, $result)
    {

        var_dump($number);
        $pad2Result = Helper::pad2($number);

        $this->assertEquals($pad2Result, $result);
    }

    public function pad2Data(): array
    {
        return [
            [-4, -4],
            [-3, -2],
            [-2, -2],
            [-1, 0],
            [0, 0],
            [1, 2],
            [2, 2],
            [3, 4],
            [4, 4]
        ];
    }
}