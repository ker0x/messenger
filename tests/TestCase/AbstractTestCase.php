<?php
namespace Kerox\Messenger\Test\TestCase;

use PHPUnit\Framework\TestCase;

class AbstractTestCase extends TestCase
{
    /**
     * @return string
     */
    protected function randomIntegerString(): string
    {
        $integerString = '';
        $numbers = '1234567890';
        for ($i = 0; $i < 16; ++$i) {
            $integerString .= $numbers[mt_rand(0, strlen($numbers) - 1)];
        }
        return $integerString;
    }
}
