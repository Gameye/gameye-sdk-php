<?php

namespace Gameye\Test;

use Gameye\SDK\GameyeHelper;
use PHPUnit\Framework\TestCase;

/**
 * @covers Gameye\SDK\GameyeHelper
 */
final class GameyeHelperTest extends TestCase
{
    public function testToDateTime()
    {
        $this->assertEquals(GameyeHelper::toDateTime(1518451384207), new \DateTime('2018-02-12T16:03:04.000Z'));
    }
}
