<?php
namespace Kerox\Messenger\Test\TestCase;

use PHPUnit\Framework\TestCase;

class AbstractTestCase extends TestCase
{
    /**
     * @return int
     */
    protected function getRandomInteger(): int
    {
        return mt_rand(1, 100000);
    }
}